<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date', 'end_date',
        'name', 'description',
        'status'
    ];

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('name', 'LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('status', 'LIKE', $value);
        });
    }

    public static function rules($id = 0)
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string', 'nullable'],
            'status' => ['in:لاغي,مكتمل,قيد التنفيذ'],
            'start_date' => ['required', 'before:end_date'],
            'end_date' => ['required'],
        ];
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'project_id', 'id');
    }
    public function financiers()
    {
        return $this->belongsToMany(Financier::class, 'financier_projects', 'financier_id', 'project_id', 'id', 'id');
    }
}
