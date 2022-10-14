<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'url', 'ourworks_id'
    ];

public function ourwork()
{
  return $this->belongsTo(ourwork::class, 'ourworks_id', 'id');
}
}
