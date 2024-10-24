<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'applicant_code',
        'classroom_id',
        'id_status_applicant',
        'id_extrakurikuler', 
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
    }
    public function classroom()
    {
        return $this->hasOne(Classroom::class, 'id', 'classroom_id');
    }

    public function statusApplicant()
    {
        return $this->belongsTo(StatusApplicant::class, 'id_status_applicant', 'id');
    }

    public function ekstrakurikuler()
    {
        return $this->belongsTo(Extra::class, 'id_extrakurikuler', 'id');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($applicant) {
            // Generate a unique applicant code if it's not provided
            if (empty($applicant->applicant_code)) {
                $applicant->applicant_code = 'APPL' . strtoupper(uniqid());
            }
        });
    }
}
