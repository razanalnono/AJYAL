<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course_date extends Model
{
    use HasFactory;

    protected $fillable=['date'];
    
    public function course(){
    return $this->belongsTo(Course::class,'course_id','id');
}

public function attendance(){
    return $this->hasOne(attendance::class,'course_date','id');
}
}