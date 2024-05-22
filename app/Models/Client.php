<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use SoftDeletes;
    protected $guard = 'estate_clients';

    protected $table = 'estate_clients';

    protected $primaryKey = 'id';

    protected $fillable = [
        'client_id', 'est_id', 'client_name', 'client_f_name', 'client_l_name', 'client_furigana','client_furigana_firstname','client_furigana_lastname',  'client_email', 'client_password', 'client_tel'
    ];

    protected $hidden = [
        'client_password', 'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'client_email';
    }

    public function getAuthPassword()
    {
        return $this->client_password;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class, 'client_id', 'client_id');
    }
    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}
