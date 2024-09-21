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

    public function users()
    {
        return $this->hasMany(User::class, 'id_school');
    }
}
