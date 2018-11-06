<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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
