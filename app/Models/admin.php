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
    use HasFactory,HasRoles,HasApiTokens;


    protected $guard = "admin";
    protected $guard_name = "admin";
    
    protected $fillable = [
        'firstName','lastName',
         'nationalID', 'gender', 
         'mobile', 'avatar',
        'email','password',
    ];
    public static function rules($id = 0)
    {
        return [
            'firstName' => ['required', 'string', 'max:255', 'min:3'],
            'lastName' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', "unique:trainees,email,$id"],
            'nationalID' => ['required', 'numeric', "unique:trainees,nationalID,$id"],
            'gender' => ['required', 'in:female,male'],
            'mobile' => ['required', 'string', "unique:trainees,mobile,$id"],
            'avatar' => ['image', 'max:1048576'],
            'groups' => ['required'],
        ];
    }
    public function setfullNameAttribute()
    {
        return ($this->firstName) . ' ' . ($this->lastName);
    }
 
}