<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizImage extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',
        'imageUrl',
        'imageSize'
    ];

}
