<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    use HasFactory,HasRoles;


    protected $guard = "admin";
    protected $guard_name = "admin";
    
    protected $fillable = [
        'firstName','lastName',
         'nationalID', 'gender', 
         'mobile', 'avatar',
        'email','password',
    ];


 
}