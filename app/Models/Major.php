<?php


// Major.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];

    // Define the relationship with classrooms

    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'major_classroom', 'major_id', 'classroom_id')->withTimestamps();
    }

}
