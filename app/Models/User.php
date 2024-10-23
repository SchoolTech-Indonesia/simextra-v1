<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Extra;
use Illuminate\Support\Str; // Add this line to import Str class
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasRoles, HasUuids;

    protected $fillable = [
        'name',
        'NISN_NIP',
        'email',
        'phone_number',
        'password',
        'status',
        'otp',
        'otp_token',
        'otp_expires_at',
        'id_role',
        'id_school'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    protected $casts = [ 
        'NISN_NIP_verified_at' => 'datetime',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'id_role');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'id_school');
    }

    public function majors()
    {
        return $this->hasMany(Major::class, 'koordinator_id');
    }

    /**
     * A User can coordinate many Majors.
     */
    public function koordinator()
    {
        return $this->belongsTo(User::class, 'koordinator_id');
    }

    public function extracurriculars()
    {
        return $this->belongsToMany(Extra::class, 'extra_has_koor', 'user_id', 'extra_id');
    }

    // Automatically generate UUID for new models
}


    /**
     * Check if the user has a specific role.
     */
    // public function hasRole($role)
    // {
    //     return $this->roles()->where('name', $role)->exists();
    // }

