<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class PresenceAbsence extends Model
{
    protected $table = 'presence_absence';
    protected $fillable = [
        'trainee_id', 'course_id', 'status', 'date'
    ];

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['date'] ?? false, function ($builder, $value) {
            $builder->whereDate('date', $value);
        });
        $builder->when($filters['course_id'] ?? false, function ($builder, $value) {
            $builder->where('course_id', $value);
        });
        $builder->when($filters['trainee_id'] ?? false, function ($builder, $value) {
            $builder->where('trainee_id', $value);
        });
        $builder->when($filters['status'] ?? false, function ($builder, $value) {
            $builder->where('status', $value);
        });
        $builder->when($filters['trainee_name'] ?? false, function ($builder, $value) {
            $builder->whereHas('trainee', function ($query) use ($value) {
                $query->where('firstName', 'Like', '%' . $value . '%')
                    ->orWhere('lastName', 'Like', '%' . $value . '%');
            });
        });
    }
    public static function rules($id = 0)
    {
        return [
            'trainee_id' => 'required',
            'course_id' => 'required',
            'status' => 'required|in:حضور,غياب',
        ];
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function trainee()
    {
        return $this->belongsTo(Trainee::class);
    }
}
