<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Trainer extends User
{
    use HasFactory,HasApiTokens,Notifiable;
    protected $fillable = [
        'firstName', 'lastName',
        'nationalID', 'gender',
        'mobile', 'avatar',
        'email', 'password',
        'salary'
    ];
    protected $appends = ['full_name'];
    
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

    public function course(){
        $this->hasOne(Course::class,'trainer_id','id');
    }
    
    public function getfullNameAttribute()
    {
        return ($this->firstName) . ' ' . ($this->lastName);
    }

   
}