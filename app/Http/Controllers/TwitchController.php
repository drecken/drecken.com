<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class TwitchController extends Controller
{
    public function twitch()
    {
        return Socialite::with('twitch')
            ->scopes(['user_subscriptions'])
            ->redirect();
    }

    public function callback(Request $request)
    {
        if ($request->has('code')) {

            $responseObject = Socialite::with('twitch')->user();

            $user = User::where('email', $responseObject->email)->first();

            $userArray = [
                'twitch_id' => $responseObject->user['_id'],
                'name' => $responseObject->user['display_name'],
                'logo' => $responseObject->user['logo'] ?: 'https://static-cdn.jtvnw.net/jtv_user_pictures/xarth/404_user_70x70.png',
                'twitch_token' => $responseObject->token,
                'twitch_refresh_token' => $responseObject->refreshToken,
                'email' => $responseObject->email,
            ];

            if (!$user) {
                $user = new User($userArray);
            } else {
                $user->fill($userArray);
            }

            $user->save();

            Auth::login($user);
        }

        return redirect()->route('index');
    }
}
