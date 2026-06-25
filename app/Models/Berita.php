<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = ['kategori_id', 'title', 'excerpt', 'body', 'image', 'status'];

    protected $dates = ['created_at'];

    public function kategori(){
        return $this->belongsTo(Kategori::class);
    }
}
