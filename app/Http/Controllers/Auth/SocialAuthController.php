<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    // Redirecting to Facebook
    public function redirectToProvider($provider)
    {
        Session::put('PREVIOUS_URL', URL::previous());

        return Socialite::driver($provider)
            ->scopes(['user_birthday', 'user_gender'])
            ->redirect();
    }

    // Obtaining user information
    public function handleProviderCallback($provider)
    {
        // Obtaining user data
        $social_user = Socialite::driver($provider)
            ->fields(['name', 'email', 'gender', 'birthday'])
            ->user();

        // Check if the user exists
        if ($user = User::where('email', $social_user->email)->first()) {
            $user->name = $social_user->name;
            $user->save();
            return $this->authAndRedirect($user); // Login y redirección
        } else {
            // In case it does not exist we create a new user with your data.
            $user = User::create([
                'facebookId' => $social_user->id,
                'facebookToken' => $social_user->token,
                'name' => $social_user->name,
                'email' => $social_user->email,
                'password' => encrypt(str_random(10)),
                'avatar' => $social_user->avatar,
                'gender' => $social_user->user['gender'],
                'birthday' => date('Y-m-d', strtotime($social_user->user['birthday'])),
            ]);

            return $this->authAndRedirect($user); // Login y redirección
        }
    }

    // Login y redirección
    public function authAndRedirect($user)
    {
        Auth::login($user);

        $redirectUrl = Session::has('PREVIOUS_URL') ? Session::get('PREVIOUS_URL') : '/#';
        return redirect()->intended($redirectUrl);
    }
}
