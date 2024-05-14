<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstateDoc extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $primaryKey = 'doc_id';

  protected $fillable = [
    'est_id',
    'doc_category',
    'doc_name',
    'doc_file',
    'doc_description'
  ];

  protected $dates = ['created_at', 'updated_at', 'deleted_at'];

  public function estate()
  {
    return $this->belongsTo('App\Estate', 'est_id');
  }
}
