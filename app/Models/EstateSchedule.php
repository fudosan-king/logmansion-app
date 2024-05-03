<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstateSchedule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'schedule_id';

    protected $fillable = [
        'est_id',
        'schedule_name',
        'schedule_description',
        'schedule_date',
        'schedule_active',
    ];

    protected $dates = ['schedule_date', 'created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        'schedule_active' => 'boolean',
    ];

    public function estate()
    {
        return $this->belongsTo('App\Estate', 'est_id');
    }
}
