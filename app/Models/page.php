<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'bio', 'vision', 'goals', 'logo'
    ];

    public static function rules($id = 0)
    {
        return [
            'bio' => 'required',
            'vision' => 'required',
            'goals' => 'required',
            'logo' => 'nullable|image',
        ];
    }
}
