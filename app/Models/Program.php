<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'image', 'start_ad', 'end_ad'
    ];
    protected $hidden = [
        'image', 'created_at', 'updated_at', 'deleted_at',
    ];
    protected $appends = [
        'image_url',
    ];

    public static function rules($id = 0)
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'start_ad' => ['nullable', 'before:end_ad'],
            'end_ad' => ['nullable'],
        ];
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return 'http://simpleicon.com/wp-content/uploads/picture.png';
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        return asset('storage/' . $this->image);
    }
}
