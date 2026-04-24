<?php

namespace App\Models;

use App\Services\FileService;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = ["name", "email", "password", "avatar", "is_active", "phone", "address"];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = ["password", "remember_token"];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
        ];
    }

    /**
     * Get the avatar URL attribute
     *
     * @return string|null
     */
    public function getAvatarUrlAttribute(): ?string
    {
        return FileService::publicUrl($this->avatar);
    }

    /**
     * Check if user has avatar
     *
     * @return bool
     */
    public function hasAvatar(): bool
    {
        return !empty($this->avatar) &&
            FileService::resolveExistingPath($this->avatar) !== null;
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getHasPurchasesAttribute(): bool
    {
        return $this->orders()->exists();
    }
}
