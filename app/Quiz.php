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
        'avatarWidth',
        'avatarHeight',
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
        return 'images' . DIRECTORY_SEPARATOR . 'quizzes' . DIRECTORY_SEPARATOR . $this->id;
    }

    public function getTemplatesDirName() {
        return $this->getStorageDirName() . DIRECTORY_SEPARATOR . 'templates';
    }
}
