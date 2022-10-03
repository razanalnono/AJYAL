<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable=['name'];
    
    public function project(){
        return $this->belongsTo(Project::class, 'project_id', 'id');

    }

    public function course(){
        return $this->hasMany(Course::class,'group_id','id');
    }

    public function trainee(){
                return $this->belongsToMany(Group::class,'group_trainee','trainee_id','group_id','id','id');

    }
    public function achievements()
    {
        return $this->hasMany(Achievements::class, 'trainee_id', 'id');
    }
}