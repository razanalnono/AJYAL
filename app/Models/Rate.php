<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Rate extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainee_id',
        'course_id',
        'rate',
        'notes',
    ];

    public function scopeFilter(Builder $builder, $filters)
    {
        $builder->when($filters['trainee_id'] ?? false, function ($builder, $value) {
            $builder->where('trainee_id', $value);
        });
        $builder->when($filters['course_id'] ?? false, function ($builder, $value) {
            $builder->where('course_id', $value);
        });
        $builder->when($filters['trainee_name'] ?? false, function ($builder, $value) {
            $builder->whereHas('trainee', function ($query) use ($value) {
                $query->where('firstName', 'Like', '%' . $value . '%')
                    ->orWhere('lastName', 'Like', '%' . $value . '%');
            });
        });
        $builder->when($filters['course_name'] ?? false, function ($builder, $value) {
            $builder->whereHas('course', function ($query) use ($value) {
                $query->where('name', 'Like', '%' . $value . '%');
            });
        });
    }

    public static function rules($id = 0)
    {
        return [
            'trainee_id' => 'required|integer|exists:trainees,id',
            'course_id' => 'required|integer|exists:courses,id',
            'rate' => 'required|integer|min:1|max:10',
            'notes' => 'string',
        ];
    }

    public function trainee()
    {
        return $this->belongsTo(Trainee::class)->withDefault();
    }
    public function course()
    {
        return $this->belongsTo(Course::class)->withDefault();
    }
}
