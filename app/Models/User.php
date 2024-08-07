<?php

namespace App\Models;

use App\Enums\RoleName;
use App\Notifications\ResetPassword;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use CanResetPassword, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'temporary_email',
        'password',
        'language',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Retrieves the roles associated with the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany The roles associated with the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Checks if the user is an admin.
     *
     * @return bool True if the user is an admin, false otherwise.
     */
    public function isAdmin(): bool
    {
        return $this->hasRole(RoleName::ADMIN);
    }

    /**
     * Checks if the user is a regular user.
     *
     * @return bool True if the user is a regular user, false otherwise.
     */
    public function isUser(): bool
    {
        return $this->hasRole(RoleName::USER);
    }

    /**
     * Checks if the user has the specified role.
     *
     * @param  RoleName  $role  The name of the role to check.
     * @return bool True if the user has the specified role, false otherwise.
     */
    public function hasRole(RoleName $role): bool
    {
        return $this->roles()->where('name', $role->value)->exists();
    }

    /**
     * Retrieves the permissions associated with the user's roles.
     *
     * @return array An array of unique permission names associated with the user's roles.
     */
    public function permissions(): array
    {
        return $this->roles()->with('permissions')->get()
            ->map(function ($role) {
                return $role->permissions->pluck('name');
            })->flatten()->values()->unique()->toArray();
    }

    /**
     * Checks if the user has the specified permission.
     *
     * @param  string  $permission  The name of the permission to check.
     * @return bool True if the user has the specified permission, false otherwise.
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions(), true);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
}
