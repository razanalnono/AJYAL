<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievements extends Model
{
    use HasFactory;
    
    public function trainee(){
        return $this->belongsTo(Trainee::class,'trainee_id','id');
    }

    public function group(){
        return $this->belongsTo(group::class,'group_id','id');
    }
}