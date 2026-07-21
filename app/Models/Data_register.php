<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_register extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'id_skema',
        'kode_skema',
        'nim',
        'surel',
        'skema_name',
        'skema_id',
        'user_id',
        'user_name',
        'status',
        'tmpt_lahir',
        'tgl_lahir',
        'sex_id',
        'negara',
        'alamat',
        'kode_post',
        'no_hp',
        'provinsi',
        'kabupaten',
        'kota',
        'kecamatan',
        'tamatan_id',
        'image',
        'jurusan_id',
        'semester_id',
        'kode',
        'ktp',
        'khs',
        'ktm',
        'lain',
        'koreksi',
        'validasi_data',
        'rekomendasi_data',
        'date',
        'time',
        'tuk_id',
        'asesor_id',
        'keterangan',
        'institusi',
        'jabatan',
        'email3',
        'fax',
        'telp',
        'postal',
        'jenis',
        'ktr',
        'tmt',
        'rmh',
        'alamat_kantor',
        'nik',
    ];

    protected $dates = ['tgl_lahir', 'date', 'created_at', 'updated_at'];

    protected $casts = [
        'validasi_data' => 'array',
        'rekomendasi_data' => 'array',
    ];

    public function xnxxes(){
        return $this->hasMany(Xnxx::class);
    }

    public function upload_files(){
        return $this->hasMany(Upload_file::class);
    }

    public function jurusan(){
        return $this->belongsTo(Jurusan::class);
    }

    public function semester(){
        return $this->belongsTo(Semester::class);
    }

    public function sex(){
        return $this->belongsTo(Sex::class);
    }

    public function asesor(){
        return $this->belongsTo(Asesor::class);
    }


    public function tuk(){
        return $this->belongsTo(Tuk::class);
    }

    public function penilaians(){
        return $this->hasMany(Penilaian::class, 'data_register_id');
    }

    public function observasis(){
        return $this->hasMany(Observasi::class, 'data_register_id');
    }

    public function permohonan(){
        return $this->hasOne(Permohonan::class, 'data_register_id');
    }

    public function frAk01(){
        return $this->hasOne(FrAk01::class, 'data_register_id');
    }

    public function frAk03(){
        return $this->hasOne(FrAk03::class, 'data_register_id');
    }

    public function frAk04(){
        return $this->hasOne(FrAk04::class, 'data_register_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
