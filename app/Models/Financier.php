<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Financier extends Model
{
    use HasFactory;
    protected $table = 'financiers';

    protected $fillable = [
        'name', 'description',
        'logo', 'link',
    ];

    public static function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'logo' => 'nullable|mimes:jpg,jpeg,png',
            'link' => 'nullable|url',
        ];
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'financier_projects', 'project_id', 'financier_id', 'id', 'id')->withDefault();
    }
}
