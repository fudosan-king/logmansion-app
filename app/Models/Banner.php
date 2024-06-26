<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'estate_banners';

    protected $primaryKey = 'banner_id';

    protected $fillable = [
        'banner_type',
        'banner_title',
        'banner_description',
        'banner_image',
        'banner_url',
        'banner_active',
    ];

    protected $casts = [
        'banner_active' => 'boolean',
    ];
}
