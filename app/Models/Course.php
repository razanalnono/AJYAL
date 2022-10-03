<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    public function group(){
        return $this->belongsTo(Group::class,'group_id','id');
    }
public function course_date(){
    return $this->hasOne(course_date::class,'course_id','id');
}

}