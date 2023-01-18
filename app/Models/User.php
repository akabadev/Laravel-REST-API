<?php

namespace App\Models;

use App\Models\Concerns\IsExportable;
use App\Models\Contracts\Exportable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @OA\Schema(
 *     @OA\Xml(name="User"),
 *     @OA\Property(property="email", type="string", format="email", description="User unique email address", example="user@gmail.com"),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="profile", ref="#/components/schemas/Profile"),
 *     @OA\Property(property="active", type="boolean", example="true")
 * )
 *
 * Class User
 * @package App\Models
 *
 * @property Profile profile
 */
class User extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract, Exportable
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, HasApiTokens;

    use HasFactory, Notifiable, SoftDeletes, IsExportable;

    protected static function boot()
    {
        parent::boot();
        self::saving(function (&$attributes = []) {
            data_set(
                $attributes,
                "username",
                strtolower($attributes['username'] ?? $attributes['email'])
            );
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "name",
        "username",
        "email",
        "password",
        "profile_id",
        "active",
    ];

    protected $appends = ['profile'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        "email_verified_at" => "datetime",
        "active" => "boolean",
    ];

    /**
     * @return BelongsTo
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    public function getProfileAttribute(): ?Profile
    {
        return $this->profile()->first();
    }
}
