<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ResponsPresensi;
use App\Models\User;
class StatusPresensi extends Model
{
    use HasFactory;

    protected $table = 'status_presensi';
    protected $fillable = [ 'name'];
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    public function respons()
    {
        return $this->hasMany(ResponsPresensi::class, 'id_status_presensi');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'respons_presensi', 'id_status_presensi', 'id_user');
    }
    public function getBadgeColorAttribute()
{
    return match($this->name) {
        'Hadir' => 'success',
        'Alpha' => 'danger',
        'Sakit', 'Izin' => 'warning',
        default => 'secondary',
    };
}
}
