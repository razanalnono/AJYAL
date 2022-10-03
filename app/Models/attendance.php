<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

public function course_date(){
    return $this->belongsTo(course_date::class,'course_date','id');
}

public function trainee(){
    return $this->belongsTo(Trainee::class,'trainee_id','id');
}
    
}