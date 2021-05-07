<?php

namespace App\Models;

use App\Models\TopUp;
use App\Models\Reports;
use App\Models\Transfer;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable  implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'verify_code',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token', 
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
   
    
    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
   
    public function accounts()
    {
        return $this->hasOne(Account::class);
    }
    public function topUp()
    {
        return $this->hasMany(TopUp::class);
    }
    public function reports()
    {
        return $this->hasMany(Reports::class);
    }
    public function transfer()
    {
        return $this->hasMany(Transfer::class);
    }

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
}
