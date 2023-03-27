<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalScore extends Model
{
    //
    protected $table = 'personal_score';
    protected $guarded = [];
    protected $cast = [
        'max_score' => 'float',
        'score' => 'float'
    ];
}
