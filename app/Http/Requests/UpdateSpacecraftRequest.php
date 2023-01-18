<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;



/**
 * @OA\RequestBody(
 *     request="UpdateSpacecraftRequest",
 *     description="UpdateSpacecraftRequest",
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
 * Class UpdateSpacecraftRequest
 * @package App\Http\Requests\UpdateSpacecraftRequest
 */
class UpdateSpacecraftRequest extends StoreSpacecraftRequest
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
        $rules = parent::rules();
        $rules['name'] = [ 'required', 'unique:spacecrafts,name,' . $this->route('spacecraft')->id ];
        $rules['image'] = [ 'image' ];

        return $rules;
    }

    public function persist()
    {
        $spacecraft = $this->route('spacecraft');
        $spacecraft->update(request([
            'name', 'class', 'crew', 'value', 'status'
        ]));
        //only update the image if present and maintain the previous image.
        if ($this->file('image')) {
            $spacecraft->deleteImageFile();
            $spacecraft->image = $this->file('image')->storePublicly('public/');
        }
        $spacecraft->save();

        $this->updateArmaments();
    }

    private function updateArmaments()
    {
        $spacecraft = $this->route('spacecraft');
        $spacecraft->armaments()->delete();
        $this->attachArmaments($spacecraft);
    }
}
