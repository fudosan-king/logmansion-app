<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Estate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'estate_data';
    protected $primaryKey = 'est_id';
    public $timestamps = true;
    protected $fillable = [
        'est_room_no',
        'est_name',
        'est_zip',
        'est_pref',
        'est_city',
        'est_ward',
        'est_address',
        'est_archive',
        'est_usefulinfo_pref_url',
        'est_usefulinfo_pref_show',
        'est_usefulinfo_city_url',
        'est_usefulinfo_city_show',
        'est_usefulinfo_ward_url',
        'est_usefulinfo_ward_show'
    ];

}
