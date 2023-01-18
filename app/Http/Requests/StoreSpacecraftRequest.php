<?php

namespace App\Http\Requests;

use App\Models\Armament;
use App\Models\Spacecraft;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;



/**
 * @OA\RequestBody(
 *     request="StoreSpacecraftRequest",
 *     description="StoreSpacecraftRequest",
 *     required=true,
 *     @OA\JsonContent(
 *        @OA\Property(property="name", type="string", example="Assassin 8719"),
 *        @OA\Property(property="class", type="string", example="Moon Lander"),
 *        @OA\Property(property="status", type="string", example="operation or damaged"),
 *        @OA\Property(property="crew", type="integer", example="1234"),
 *        @OA\Property(property="fleet_id", type="integer", example="1234"),
 *        @OA\Property(property="value", type="float", example="20.76"),
 *        @OA\Property(property="image", type="string", example="image.jpg"),
 *     )
 * )
 *
 * Class StoreSpacecraftRequest
 * @package App\Http\Requests\StoreSpacecraftRequest
 */
class StoreSpacecraftRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => [ 'required', new Unique('spacecrafts', 'name') ],
            'status' => [ 'required', Rule::in([ Spacecraft::STATUS_DAMAGED, Spacecraft::STATUS_OPERATIONAL ]) ],
            'class' => [ 'required', Rule::in(Spacecraft::CLASSES) ],
            'crew' => [ 'required', 'numeric' ],
            'image' => [ 'required', 'image' ],
            'value' => [ 'required', 'numeric' ],
            'armaments' => [ 'required', 'array' ],
        ];

        if ($this->get('armaments')) {
            foreach ($this->get('armaments') as $key => $value) {
                $rules["armaments.{$key}.title"] = [ 'required' ];
                $rules["armaments.{$key}.qty"] = [ 'required', 'numeric' ];
            }
        }

        return $rules;
    }

    public function persist()
    {
        $spacecraft = new Spacecraft();
        $spacecraft->fill(request([ 'name', 'class', 'crew', 'value', 'status' ]));
        $spacecraft->image = $this->file('image')->storePublicly('public/');
        $spacecraft->fleet_id = auth()->user()->fleet_id;
        $spacecraft->save();

        $this->attachArmaments($spacecraft);

        return $spacecraft;
    }

    protected function attachArmaments(Spacecraft $spacecraft)
    {
        if (! $this->get('armaments')) {
            return;
        }

        //performance can be improved using batch insert
        foreach ($this->get('armaments') as $inputArmament) {
            $armament = new Armament();
            $armament->title = $inputArmament['title'];
            $armament->qty = $inputArmament['qty'];
            $armament->spacecraft_id = $spacecraft->id;
            $armament->save();
        }
    }
}
