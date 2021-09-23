<?php

namespace App\Models;

use App\Models\Address\Address;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles', 'user_id', 'role_id');
    }

    public function contactInformation()
    {
        return $this->hasOne(ContactInformation::class);
    }

    public function demands()
    {
        return $this->hasMany(PartsDemand::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function hasRole(string $roleDescription)
    {
        $userRoles = $this->roles()->where('description', $roleDescription)->exists();
        if ($userRoles) return true;
        return false;
    }

    public function assignRole(string $roleDescription)
    {
        $role = Role::where('description', $roleDescription)->get()->first();
        if ($role == null) {
            $role = Role::create([
                'description' => $roleDescription,
            ]);
        }
        if (!$this->hasRole($roleDescription)) {
            $this->roles()->attach($role);
        }
        return true;
    }
}
