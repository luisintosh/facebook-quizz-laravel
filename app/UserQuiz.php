<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
        'imageSize',
        'title',
        'description'
    ];

    /**
     * Get the related quiz
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function quiz() {
        return $this->hasOne('App\Quiz');
    }

    /**
     * Return the asset's URL
     * @return string
     */
    public function getImageUrl()
    {
        return empty($this->imageUrl)
            ? asset('images/quizzes/quizCoverImagePlaceholder.png')
            : Storage::disk('public')->url($this->imageUrl) ;
    }
}
