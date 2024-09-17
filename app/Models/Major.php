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
    ];


    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }

    public function koordinator()
    {
        return $this->belongsTo(User::class, 'koordinator_id');
    }

    // Static method to generate a unique code for a new major
    public static function generateCode()
    {
        return 'MJR' . str_pad(self::count() + 1, 3, '0', STR_PAD_LEFT);
    }
    public function show(Major $major)
    {
    // Load related coordinators and classrooms
    $major->load('koordinator', 'classrooms');

    return response()->json(['major' => $major]);
    }   

}
