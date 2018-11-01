<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserQuiz extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quiz_id',
        'user_id',
        'imageUrl',
        'imageSize'
    ];

    /**
     * Get the related quiz
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function quiz() {
        return $this->hasOne('App\Quiz');
    }
}
