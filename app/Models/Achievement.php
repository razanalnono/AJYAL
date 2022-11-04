<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title', 'job_description', 'attachment',
        'job_link', 'salary', 'status',
        'other', 'platform_id', 'group_id',
        'trainee_id',
    ];

    public static function rules($id = 0) {
        return [
            'platform_id' => 'required|integer|exists:platforms,id',
            'other' => 'nullable|string|max:255',
            'trainee_id' => 'required|integer|exists:trainees,id',
            'group_id' => 'required|integer|exists:groups,id',
            'job_title' => 'required|string|max:255',
            'job_description' => 'string|max:500|nullable',
            'attachment' => 'nullable|file',
            'job_link' => 'string|nullable',
            'salary' => 'required|numeric',
            'status' => 'required|string|in:مكتمل,قيد التنفيذ',
        ];
    }

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['platform_id'] ?? false, function ($builder, $value) {
            $builder->where('platform_id', $value);
        });
        $builder->when($filters['group_id'] ?? false, function ($builder, $value) {
            $builder->where('group_id', $value);
        });
        $builder->when($filters['trainee_id'] ?? false, function ($builder, $value) {
            $builder->where('trainee_id', $value);
        });
        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('status', $value);
        });
    }


    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'trainee_id', 'id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
    public function platform()
    {
        return $this->belongsTo(Platform::class)->withDefault();
    }
}
