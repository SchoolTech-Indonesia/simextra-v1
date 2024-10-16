<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Presensi;
use App\Models\StatusPresensi;
use App\Models\User;

class ResponsPresensi extends Model
{
    use HasFactory;

    protected $table = 'respons_presensi';
    protected $fillable = ['id_presensi', 'id_status_presensi'];
    protected $primaryKey = 'uuid';
    protected $keyType = 'string';
    public $incrementing = false;

    public function presensi()
    {
        return $this->belongsTo(Presensi::class, 'id_presensi');
    }

    public function status()
    {
        return $this->belongsTo(StatusPresensi::class, 'id_status_presensi');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
