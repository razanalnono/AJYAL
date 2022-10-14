<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ourwork extends Model
{
    use HasFactory;

    protected $fillable = [
        'report'
    ];

    public function images()
    {
        return $this->hasMany(Image::class, 'ourworks_id', 'id');
    }
}
