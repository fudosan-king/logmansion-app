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
    'contact_note',
  ];

  protected $dates = ['created_at', 'updated_at', 'deleted_at'];

  public function contact()
  {
    return $this->belongsTo(Contact::class, 'contact_id', 'contact_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'author', 'id');
  }

  public function contactFiles()
  {
    return $this->hasMany(ContactFile::class, 'id', 'contact_detail_id');
  }
}
