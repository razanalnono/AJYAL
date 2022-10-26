<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurWork extends Model
{
    use HasFactory;
    protected $fillable = ['report','deleted_images'];
    protected $table="ourworks";


    public function images()
    {
        return $this->morphMany(Image::class, 'reference');
    }


    protected static function boot()
    {
        parent::boot();

        static::deleted(function ($work) {
            $work->images()->delete();
        });
    }
}