<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StatusApplicant extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'id_status_applicant', 'id');
    }
}
