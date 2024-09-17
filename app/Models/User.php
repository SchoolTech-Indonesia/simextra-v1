<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, HasRoles;

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

    public function customRole()
    {
        return $this->belongsTo(\Spatie\Permission\Models\Role::class, 'role_id');
    }
    
    public function schools()
    {
        return $this->belongsToMany(School::class, 'school_user', 'id_user', 'id_school');
    }
    
    // User.php
    public function majors()
    {
    return $this->hasMany(Major::class, 'koordinator_id');
    }

}
