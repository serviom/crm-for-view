<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phoneNumber',
        'password',
        'avatar',
        'telegram_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function clients()
    {
        return $this->hasMany(Client::class)->with('events');
    }

    public function seniorAgent()
    {
        return $this->hasOne(SeniorAgent::class, 'user_id');
    }

    public function subAgents()
    {
        return $this->hasMany(SeniorAgent::class, 'senior_agent_id');
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setPhoneNumberAttribute($value)
    {
        $value= str_replace( ['+38', ' ' , '(', ')', '-'],  '',  $value);
        $this->attributes['phoneNumber'] = $value;
    }

    public function getItem($id)
    {
        return $this->with([
            'roles',
            'permissions',
        ])->find($id);
    }

    public static function getItems()
    {
        return self::All();
    }
}
