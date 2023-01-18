<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Format"),
 *     @OA\Property(property="code", type="string", example="2628772687"),
 *     @OA\Property(property="description", type="string", example="Description"),
 *     @OA\Property(property="name", type="string", example="Nom"),
 *     @OA\Property(property="config_file", type="string", example="file.json")
 * )
 *
 * Class Format
 * @package App\Models
 */
class Format extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "code",
        "description",
        "name",
        "config_file",
    ];
}
