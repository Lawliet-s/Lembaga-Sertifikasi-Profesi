<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skkni extends Model
{
    use HasFactory;
    protected $fillable = ['file', 'skema_id', 'image'];

    public function skema(){
        return $this->belongsTo(Skema::class);
    }
}
