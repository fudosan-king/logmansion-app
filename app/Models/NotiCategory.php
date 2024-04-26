<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotiCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'notification_category';
    protected $primaryKey = 'cat_id';
    protected $fillable = [
        'cat_name'
    ];
}
