<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public const ADMIN_ROLE = 'admin';
    public const USER_ROLE = 'user';

    public const ROLES = [
        self::ADMIN_ROLE,
        self::USER_ROLE,
    ];
    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
