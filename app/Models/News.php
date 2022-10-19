<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable=['title','description','in_slider'];

  public function images(){
    return $this->morphMany(Images::class,'reference');
  }

  
}