<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faq';

    protected $primaryKey = 'faq_id';

    protected $fillable = [
        'faq_title',
        'faq_content',
        'faq_active',
    ];

    protected $casts = [
        'faq_active' => 'boolean',
    ];
}
