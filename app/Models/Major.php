<?php


// Major.php
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

    // Define the relationship with classrooms
    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }
    // Static method to generate a unique code for a new major
    public static function generateCode()
    {
        return 'MJR' . str_pad(self::count() + 1, 3, '0', STR_PAD_LEFT);
    }

    // Use the model's boot method to generate the code before creating a major
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($major) {
            // Automatically generate a unique code if it's not provided
            if (empty($major->code)) {
                $major->code = self::generateCode();
            }
        });
    }
}
