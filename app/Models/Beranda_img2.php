<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beranda_img2 extends Model
{
    protected $fillable = ['nama', 'keterangan', 'image', 'no_hp', 'email', 'facebook', 'twitter', 'instagram'];
    protected $table = 'pengelola';

    public function getImageAttribute($value)
    {
        return $value ?: 'general/assets/images/photo.jpg';
    }
}
