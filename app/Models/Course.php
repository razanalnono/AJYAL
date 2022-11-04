<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'start_date', 'end_date', 
        'trainer_id', 'group_id', 'description',
        'hour_count', 'status',
    ];

    public function scopeFilter (Builder $builder, $filters) 
    {
        $builder->when($filters['name'] ?? false, function($builder, $value){
            $builder->where('name', 'LIKE', "%{$value}%");
        });
        $builder->when($filters['status'] ?? false, function($builder, $value){
            $builder->where('status', 'LIKE', $value);
        });
    }

    public static function rules($id = 0) {
        return [
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'before:end_date'],
            'end_date' => ['required'],
            'group_id'=>['required', 'exists:groups,id'],
            'trainer_id'=>['required', 'exists:trainers,id'],
            'description' => ['nullable'],
            'hour_count' => ['integer'],
            'status' => ['string', 'in:لاغي,مكتمل,قيد التنفيذ'],
        ];
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id', 'id');
    }
    public function presence_absence()
    {
        return $this->hasMany(PresenceAbsence::class, 'course_id');
    }
    public function rates()
    {
        return $this->hasMany(Rate::class, 'course_id', 'id')->withDefault();
    }
}
