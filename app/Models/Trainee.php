<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Trainee extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = [
        'firstName', 'lastName',
        'nationalID', 'gender',
        'mobile', 'avatar',
        'email', 'password',
    ];

    public function groups(){
        return $this->belongsToMany(Group::class,'group_trainee','trainee_id','group_id','id','id');
    }

     public function attendance(){
        return $this->hasMany(attendance::class,'trainee_id','id');
    }

    public function achievements(){
        return $this->hasMany(Achievements::class,'trainee_id','id');
    }

    public function setfullNameAttribute()
    {
        return ($this->firstName) . ' ' . ($this->lastName);
    }

    
}