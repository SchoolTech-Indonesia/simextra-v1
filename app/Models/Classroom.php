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
        'major_id',
        'address'
    ];

    public $timestamps = true;

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

//!! Silahkan pakai ini, Jika sudah ada mahasiswanya untuk menampilkan detail students
//     public function students()
// {
//     return $this->hasMany(Student::class);
// }
}