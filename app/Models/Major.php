<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',

    ];

    public $timestamps = true;

public function classrooms()
{
    return $this->hasMany(Classroom::class);
}

}
