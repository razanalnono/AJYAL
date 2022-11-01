<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class Trainee extends User
{
    use HasFactory, HasApiTokens;
    protected $fillable = [
        'firstName', 'lastName',
        'nationalID', 'gender',
        'mobile', 'avatar',
        'email', 'password',
        'carriagePrice', 'address',
        'city_id', 'activation_code'
    ];

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['trainee_name'] ?? false, function ($builder, $value) {
            $builder->where('firstName', 'Like', '%' . $value . '%')
            ->orWhere('lastName', 'Like', '%' . $value . '%');
        });
        // $builder->when($filters['carriagePrice'] ?? false, function ($builder, $value) {
        //     $builder->where('carriagePrice', $value);
        // });
        // $builder->when($filters['trainee_id'] ?? false, function ($builder, $value) {
        //     $builder->where('trainee_id', $value);
        // });
        // $builder->when($filters['status'] ?? false, function ($builder, $value) {
        //     $builder->where('status', $value);
        // });
        // $builder->when($filters['trainee_name'] ?? false, function ($builder, $value) {
        //     $builder->whereHas('trainee', function ($query) use ($value) {
        //         $query->where('firstName', 'Like', '%' . $value . '%')
        //             ->orWhere('lastName', 'Like', '%' . $value . '%');
        //     });
        // });
    }

    public static function rules($id = 0)
    {
        return [
            'firstName' => ['required', 'string', 'max:255', 'min:3'],
            'lastName' => ['required', 'string', 'max:255', 'min:3'],
            'email' => ['required', "unique:trainees,email,$id"],
            // 'password' => ['required', 'min:3'],
            'nationalID' => ['required', 'numeric', "unique:trainees,nationalID,$id"],
            'gender' => ['required', 'in:female,male'],
            'mobile' => ['required', 'string', "unique:trainees,mobile,$id"],
            'avatar' => ['image', 'max:1048576'],
            'groups' => ['required'],
            'carriagePrice' => ['nullable', 'numeric'],
            'address' => ['nullable', 'string'],
            'city_id' => ['nullable', 'int', 'exists:cities,id'],
        ];
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_trainee', 'trainee_id', 'group_id', 'id', 'id');
    }
    public function achievements()
    {
        return $this->hasMany(Achievements::class, 'trainee_id', 'id');
    }
    public function city()
    {
        return $this->belongsTo(city::class, 'city_id', 'id');
    }
    public function presence_absence()
    {
        return $this->hasMany(PresenceAbsence::class, 'trainee_id');
    }
    public function rates()
    {
        return $this->hasMany(Rate::class, 'course_id', 'id')->withDefault();
    }
    public function setfullNameAttribute()
    {
        return ($this->firstName) . ' ' . ($this->lastName);
    }
}
