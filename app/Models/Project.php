<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'start_date', 'end_date',
        'name', 'financier',
    ];
     
    public function groups(){
        return $this->hasMany(Group::class, 'project_id', 'id');
    }
}