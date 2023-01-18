<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;




/**
 * @OA\Schema(
 *     @OA\Xml(name="Spacecraft"),
 *     @OA\Property(property="name", type="string", example="Assassin 8719"),
 *     @OA\Property(property="class", type="string", example="Moon Lander"),
 *     @OA\Property(property="status", type="string", example="operation or damaged"),
 *     @OA\Property(property="crew", type="integer", example="1234"),
 *     @OA\Property(property="fleet_id", type="integer", example="1234"),
 *     @OA\Property(property="value", type="float", example="20.76"),
 *     @OA\Property(property="image", type="string", example="image.jpg"),
 * )
 *
 * Class Spacecraft
 * @package App\Models
 */
class Spacecraft extends Model
{

    use HasFactory;

    const STATUS_OPERATIONAL = 1;
    const STATUS_DAMAGED = 2;

    const CLASSES = [
        'Star Destroyer',
        'Meteoroid Breaker',
        'Moon Lander',
        'Planet Invader'
    ];

    protected $fillable = [
        'name',
        'class',
        'crew',
        'value',
        'status'
    ];

    public function getStatusLabelAttribute()
    {
        return $this->status == static::STATUS_OPERATIONAL ? "operational": "damaged";
    }

    public function getPrettyValueAttribute()
    {
        return number_format($this->value, 2);
    }

    public function getPrettyCrewAttribute()
    {
        return number_format($this->crew);
    }

    public function armaments(): HasMany
    {
        return $this->hasMany(Armament::class);
    }

    public function trash()
    {
        $this->deleteImageFile();
        $this->delete();
    }

    public function deleteImageFile()
    {
        if (Storage::exists($this->image)) {
            Storage::delete($this->image);
        }
    }

    //this can be a local scope query too.
    public static function search($data)
    {
        $spacecrafts = Spacecraft::where('id', '!=', 0);

        if (isset($data['name']) and $data['name'] != '') {
            $spacecrafts = $spacecrafts->where('name', 'LIKE', '%' . $data['name'] . '%');
        }

        if (isset($data['class']) and $data['class'] != " ") {
            $spacecrafts = $spacecrafts->where('class', 'LIKE', '%' . $data['class'] . '%');
        }

        if (isset($data['status']) and $data['status'] > 0) {
            $spacecrafts = $spacecrafts->where('status', $data['status']);
        }

        return $spacecrafts->get();
    }
}
