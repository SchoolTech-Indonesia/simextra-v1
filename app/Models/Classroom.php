<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'created_by',
        'updated_by',
        'status',
    ];

    public $timestamps = true;

public function major()
{
    return $this->belongsTo(Major::class);
}
}