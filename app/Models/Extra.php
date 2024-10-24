<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Extra extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'logo'];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function coordinators()
    {
        return $this->belongsToMany(User::class, 'extra_has_koor', 'extra_id', 'user_id');
    }
}