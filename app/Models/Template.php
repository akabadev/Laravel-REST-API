<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Template"),
 *     @OA\Property(property="code", type="string", example="2628772687"),
 *     @OA\Property(property="description", type="string", example="Description"),
 *     @OA\Property(property="name", type="string", example="Nom"),
 *     @OA\Property(property="template_file", type="string", example="file.json")
 * )
 *
 * Class Template
 * @package App\Models
 */
class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        "code",
        "description",
        "name",
        "template_file",
    ];
}
