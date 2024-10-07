<?php
// Classroom.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'major_id'
    ];

    public $timestamps = true;

    // Define the relationship with majors
    public function major()
    {
        return $this->belongsTo(Major::class);
    }
    
    public static function boot()
    {
        parent::boot();

        static::creating(function ($classroom) {
            // Generate a unique code if it's not provided
            if (empty($classroom->code)) {
                $classroom->code = 'CLSRM' . strtoupper(uniqid());
            }
        });
    }
}

//!! Silahkan pakai ini, Jika sudah ada mahasiswanya untuk menampilkan detail students
//     public function students()
// {
//     return $this->hasMany(Student::class);
// }