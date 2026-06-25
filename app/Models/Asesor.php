<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asesor extends Model
{
    use HasFactory;

    protected $table = 'asesor';
    protected $fillable = [
        'no_registrasi',
        'user_id',
        'nama',
        'image',
        'alamat',
        'sex',
        'email',
        'no_hp' ,
        'skema' ,
        'status'];

    public function skemas(){
        return $this->hasMany(Skema::class);
    }

    public function data_registers(){
        return $this->hasMany(Data_register::class, 'asesor_id');
    }

    public function penilaians(){
        return $this->hasManyThrough(
            Penilaian::class,
            Data_register::class,
            'asesor_id',
            'data_register_id'
        );
    }

    public function observasis(){
        return $this->hasManyThrough(
            Observasi::class,
            Data_register::class,
            'asesor_id',
            'data_register_id'
        );
    }
}
