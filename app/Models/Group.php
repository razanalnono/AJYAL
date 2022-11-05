<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'project_id',
        'description', 'hour_count',
        'start_date', 'end_date', 'status'
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
            'project_id' => ['required', 'exists:projects,id'],
            'description' => ['nullable'],
            'hour_count' => ['string'],
            'start_date' => ['required', 'before:end_date'],
            'end_date' => ['required'],
            'status' => ['in:لاغي,مكتمل,قيد التنفيذ'],
        ];
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function course()
    {
        return $this->hasMany(Course::class, 'group_id', 'id');
    }
    public function trainees()
    {
        return $this->belongsToMany(Trainee::class, 'group_trainee', 'trainee_id', 'group_id', 'id', 'id');
    }
    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'trainee_id', 'id');
    }
}
