<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;

    protected $table = 'catalogue';

    protected $primaryKey = 'cata_id';

    protected $fillable = [
        'cata_title',
        'cata_description',
        'cata_image',
        'cata_url',
        'cata_active',
        'cate_index',
    ];
}
