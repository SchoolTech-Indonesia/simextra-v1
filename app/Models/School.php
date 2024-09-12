<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $table = 'schools';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'logo_img',
        'name',
        'address',
    ];

    protected $hidden = [
    
    ];

    protected $casts = [
      
    ];


    public function users()
    {
        return $this->belongsToMany(User::class, 'school_user');
    }


}
