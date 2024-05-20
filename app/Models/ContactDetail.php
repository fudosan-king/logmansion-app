<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactDetail extends Model
{
  use HasFactory;
  use SoftDeletes;
  protected $table = 'estate_contact_detail';
  protected $primaryKey = 'id';

  protected $fillable = [
    'contact_id',
    'contact_message',
    'author',
    'author_type',
    'reponse_type'
  ];

  protected $dates = ['created_at', 'updated_at', 'deleted_at'];

  public function contact()
  {
    return $this->belongsTo(Contact::class, 'contact_id', 'contact_id');
  }
}
