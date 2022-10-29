<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievements extends Model
{
    use HasFactory;

    protected $fillable = [
        'platform', 'other', 'income', 'group_id', 'trainee_id',
    ];

    public function trainee()
    {
        return $this->belongsTo(Trainee::class, 'trainee_id', 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
