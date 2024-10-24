<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    use HasFactory;
    protected $fillable = [
        'school_year_code',
        'school_id',
        'start_date',
        'end_date',
        'status',

    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

}
