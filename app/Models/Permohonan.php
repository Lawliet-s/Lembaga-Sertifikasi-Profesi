<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;

    protected $table = 'permohonan_sertifikasis';

    protected $fillable = [
        'user_id',
        'skema_id',
        'data_register_id',
        'tujuan_asesmen',
        'status',
        'catatan',
        'ttd',
    ];

    public function dataRegister()
    {
        return $this->belongsTo(Data_register::class, 'data_register_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skema()
    {
        return $this->belongsTo(Skema::class);
    }

    public function dataPribadi()
    {
        return $this->hasOne(DataPribadi::class, 'permohonan_id');
    }

    public function pekerjaan()
    {
        return $this->hasOne(Pekerjaan::class, 'permohonan_id');
    }

    public function dokumens()
    {
        return $this->hasMany(Dokumen::class, 'permohonan_id');
    }
}
