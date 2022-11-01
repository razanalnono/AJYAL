<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class city extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public static function rules($id = 0)
    {
        return [
            'name' => ['required', 'string']
        ];
    }

    public function trainees()
    {
        return $this->hasMany(Trainee::class, 'city_id', 'id');
    }
}
