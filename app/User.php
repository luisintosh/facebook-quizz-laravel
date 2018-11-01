<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebookId', 'facebookToken', 'name', 'email', 'avatar', 'password', 'gender', 'birthday'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getStorageDirName()
    {
        return 'images' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR . $this->id;
    }

    public static function isAdminUser()
    {
        $isAdminUser = false;

        $adminUsers = Settings::get('users_admin');
        if(empty($adminUsers)) {
            return true;
        }

        $adminUsers = explode(',', $adminUsers);

        return in_array(Auth::user()->email, $adminUsers);
    }
}
