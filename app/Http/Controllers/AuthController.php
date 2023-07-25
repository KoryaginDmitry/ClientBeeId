<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{
    /**
     * Редирект для авторизации через bee-id
     *
     * @return \Illuminate\Http\RedirectResponse|RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('bee_id')->redirect();
    }

    /**
     * Сохраняем данные пользователя и перенаправляем в профиль
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(): \Illuminate\Http\RedirectResponse
    {
        $socialiteUser = Socialite::driver('bee_id')->user();

        //Получаем пользователя
        $user = User::firstOrCreate(
            [
                'email' => $socialiteUser->email,
            ],
            [
                'bee_id' => $socialiteUser->id,
                'name' => $socialiteUser->name,
                'post' => $socialiteUser->post,
                'phone' => $socialiteUser->phone,
            ]
        );

        //Сохраняем токены
        $user->update([
            'access_token' => $socialiteUser->token,
            'refresh_token' => $socialiteUser->refreshToken,
            'expires_in' => $socialiteUser->expiresIn
        ]);

        Auth::login($user);

        return redirect()->route('profile.show');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
