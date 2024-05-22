<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactFile extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'estate_contact_attach';
  protected $primaryKey = 'id';

  protected $fillable = [
    'contact_detail_id',
    'path_file',
  ];

  protected $dates = ['created_at', 'updated_at', 'deleted_at'];

  public function contactDetail()
  {
    return $this->belongsTo(Contact::class, 'contact_detail_id', 'id');
  }
}
