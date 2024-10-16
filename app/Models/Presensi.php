<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResponsPresensi;
use App\Models\User;

class Presensi extends Model
{
    use HasFactory;
    protected $table = 'presensi';
    protected $fillable = ['name', 'start_date', 'end_date'];
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;
    
    public function respons()
    {
        return $this->hasMany(ResponsPresensi::class, 'id_presensi');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'respons_presensi', 'id_presensi', 'id_user');
    }
}
