<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{

    const COVER_IMAGE_NAME = 'cover.jpg';
    const THUMB_IMAGE_NAME = 'thumb.jpg';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'description',
        'resultTitle',
        'resultDescription',
        'avatarPositionX',
        'avatarPositionY',
        'coverImage',
        'thumbImage',
        'enabled'
    ];

    /**
     * Get all the related images
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images() {
        return $this->hasMany('App\QuizImage');
    }

    public function getStorageDirName() {
        return 'quizzes' . DIRECTORY_SEPARATOR . $this->id;
    }
}
