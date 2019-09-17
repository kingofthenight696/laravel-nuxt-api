<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'second_name',
        'third_name',
        'role_id',
        'email',
        'gender',
        'phone',
        'city',
        'street',
        'building_number',
        'apartment_number',
        'photo',
        'password',
        'created_at',
        'updated_at',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeAdminRole($query)
    {
        return $query->whereHas('role', function ($query) {
            return $query->whereName(Role::ADMIN_ROLE);
        });
    }

    public function scopeUserRole($query)
    {
        return $query->whereHas('role', function ($query) {
            return $query->whereName(Role::USER_ROLE);
        });
    }

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
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getFullNameAttribute()
    {
        return "{$this->name}  {$this->second_name} {$this->third_name}";
    }

    public function getFullAddressAttribute()
    {
        return "{$this->city} {$this->street} {$this->building_number} {$this->apartment_number}";
    }


}
