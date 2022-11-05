<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'icon', 'url',
    ];

    public static function rules($id = 0)
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'icon' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=100'],
            'url' => ['required', 'url'],
        ];
    }
}
