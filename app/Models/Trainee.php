<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Trainee extends User
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $fillable = [
        'firstName', 'lastName',
        'nationalID', 'gender',
        'mobile', 'avatar',
        'email', 'password',
    ];

    public static function rules($id = 0) {
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