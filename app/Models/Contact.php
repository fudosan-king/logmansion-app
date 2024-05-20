<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
  use HasFactory;
  use SoftDeletes;

  protected $table = 'estate_contact';

  protected $primaryKey = 'contact_id';

  protected $fillable = [
    'client_id',
    'contact_type',
    'contact_spot',
    'contact_status',
    'contact_title',
    'contact_comment',
    'user_id'
  ];

  protected $dates = ['created_at', 'updated_at', 'deleted_at'];

  public function client()
  {
    return $this->belongsTo(Client::class, 'client_id', 'client_id');
  }

  public function contactFiles()
  {
    return $this->hasMany(ContactFile::class, 'contact_id', 'contact_id');
  }

  public function contactDetails()
  {
    return $this->hasMany(ContactDetail::class, 'contact_id', 'contact_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id', 'id');
  }
}
