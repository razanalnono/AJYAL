<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory;
    protected $fillable=['images','reference_type','reference_id'];

    
    public function images(){
        return $this->morphTo();
    }
    
}