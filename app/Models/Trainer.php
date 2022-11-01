<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Laravel\Sanctum\HasApiTokens;

class Trainer extends User
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'firstName', 'lastName',
        'nationalID', 'gender',
        'mobile', 'avatar',
        'email', 'password',
        'salary'
    ];
    protected $appends = ['full_name'];

    public function course()
    {
        $this->hasOne(Course::class, 'trainer_id', 'id');
    }
    public function getfullNameAttribute()
    {
        return ($this->firstName) . ' ' . ($this->lastName);
    }
}
