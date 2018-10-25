<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    // Metodo encargado de la redireccion a Facebook
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)
            ->scopes(['user_birthday', 'user_gender'])
            ->redirect();
    }

    // Metodo encargado de obtener la información del usuario
    public function handleProviderCallback($provider)
    {
        // Obtenemos los datos del usuario
        $social_user = Socialite::driver($provider)
            ->fields(['name', 'email', 'gender', 'birthday'])
            ->user();

        // Comprobamos si el usuario ya existe
        if ($user = User::where('email', $social_user->email)->first()) {
            return $this->authAndRedirect($user); // Login y redirección
        } else {
            // En caso de que no exista creamos un nuevo usuario con sus datos.
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

        return redirect()->intended('/#');
    }
}
