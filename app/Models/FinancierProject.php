<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancierProject extends Model
{
    use HasFactory;

    protected $table = 'financier_projects';
    protected $fillable = ['project_id','financier_id'];
}
