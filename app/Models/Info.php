<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Info extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'address', 'mobile', 'telephone', 'fax',
    ];

    public static function rules($id = 0)
    {
        return [
            'email' => ['required', 'email', 'max:255', "unique:infos,email,$id"],
            'address' => ['nullable', 'max:255'],
            'mobile' => ['string', 'max:255', "unique:infos,mobile,$id", 'nullable'],
            'telephone' => ['string', 'max:255', "unique:infos,telephone,$id", 'nullable'],
            'fax' => ['nullable', 'max:255', "unique:infos,fax,$id"],
        ];
    }
}
