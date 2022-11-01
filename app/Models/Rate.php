<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;
    protected $fillable = [
        'trinee_id',
        'course_id',
        'rate',
        'notes',
    ];

    public function trinee()
    {
        return $this->belongsTo(Trainee::class)->withDefault();
    }
    public function course()
    {
        return $this->belongsTo(Course::class)->withDefault();
    }
}
