<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'platform', 'uid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    public function wallet()
    {
        return $this->hasMany(Wallet::class);
    }

    public function revenue()
    {
        return $this->hasMany(Revenue::class);
    }

    public function getIsAdminAttribute()
    {
        return !!$this->admin;
    }

    public function scopeEmail($query, $email)
    {
        return $query->where('email', 'LIKE', '%'.$email.'%');
    }
}
