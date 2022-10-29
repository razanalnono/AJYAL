<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Admin as Authenticatable;
use Illuminate\Foundation\Auth\User;

use Laravel\Sanctum\HasApiTokens;


class Admin extends User
{
    use HasFactory, HasRoles, HasApiTokens;


    protected $guard = "admin";
    protected $guard_name = "admin";

    protected $fillable = [
        'firstName', 'lastName',
        'nationalID', 'gender',
        'mobile', 'avatar',
        'email', 'password',
    ];

    public function setfullNameAttribute()
    {
        return ($this->firstName) . ' ' . ($this->lastName);
    }
}
