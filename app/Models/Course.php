<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_date', 'end_date','trainer_id','group_id','link'];

    
    public function group(){
        return $this->belongsTo(Group::class,'group_id','id');
    }
public function course_date(){
    return $this->hasOne(course_date::class,'course_id','id');
}

    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'id');
    }

   

}