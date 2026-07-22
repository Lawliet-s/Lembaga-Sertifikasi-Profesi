<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory;

    protected $fillable = ['logo', 'logo2', 'logo3', 'logo4', 'footer_text', 'title', 'favicon', 'header_image', 'background_image', 'about_image', 'maps_embed', 'address', 'phone', 'instagram', 'facebook', 'twitter', 'email', 'primary_color', 'secondary_color', 'kepala_lsp_name', 'foto_signature'];
}
