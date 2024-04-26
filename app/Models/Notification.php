<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'notifications';
    protected $primaryKey = 'noti_id';
    protected $fillable = [
        'cat_id', 
        'noti_title', 
        'noti_content', 
        'noti_date', 
        'noti_status', 
        'noti_url'
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\NotiCategory', 'cat_id', 'cat_id');
    }
}
