<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('name', 'Like', '%' . $value . '%');
        });
    }

    public static function rules($id = 0)
    {
        return [
            'name'=>'required|string',
        ];
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class)->withDefault();
    }
}
