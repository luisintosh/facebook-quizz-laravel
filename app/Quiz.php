<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Get all the quizzes made by the users
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usersQuizzes() {
        return $this->hasMany('App\UserQuiz');
    }

    public function getStorageDirName() {
        return 'images' . DIRECTORY_SEPARATOR . 'quizzes' . DIRECTORY_SEPARATOR . $this->id;
    }

    public function getTemplatesDirName() {
        return $this->getStorageDirName() . DIRECTORY_SEPARATOR . 'templates';
    }

    /**
     * Return the asset's URL
     * @return string
     */
    public function getCoverUrl()
    {
        return empty($this->coverImage)
            ? asset('images/quizzes/quizCoverImagePlaceholder.png')
            : Storage::disk('public')->url($this->coverImage);
    }

    /**
     * Return the asset's URL
     * @return string
     */
    public function getThumbUrl()
    {
        return empty($this->thumbImage)
            ? asset('images/quizzes/quizCoverImagePlaceholder.png')
            : Storage::disk('public')->url($this->thumbImage);
    }

    /**
     * HOT Quizzes
     */
    public static function random($limit = 10) {
        return Quiz::where('enabled', 1)->inRandomOrder()->limit($limit)->get();
    }
}
