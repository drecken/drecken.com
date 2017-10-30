<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    protected $channelName;
    protected $channelId;
    protected $token;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            view()->share('user', Auth::user());

            return $next($request);
        });
    }

    public function index()
    {
        $welcome = 'Nie znam Cię typie.';
        if ($this->isFollowing()) {
            $welcome = 'Elo śledziu.';
        }
        if ($this->isSubscribed()) {
            $welcome = 'Elo subskrybencie.';
        }
        if (Auth::user()->twitch_id === (int)env('MY_CHANNEL_ID')) {
            $welcome = 'Elo szefie.';
        }

        return view('dashboard', compact('welcome'));
    }

    protected function isSubscribed()
    {
        $user = Auth::user();

        $options = [
            'headers' => [
                'Accept' => 'application/vnd.twitchtv.v5+json',
                'Client-ID' => env('TWITCH_KEY'),
                'Authorization' => 'OAuth ' . $user->twitch_token,
            ],
            'exceptions' => false,
        ];

        $client = new Client(['base_uri' => 'https://api.twitch.tv/kraken/']);
        $response = $client->request(
            'GET',
            'users/' . $user->twitch_id . '/subscriptions/' . env('MY_CHANNEL_ID'),
            $options
        );
        if ($response->getStatusCode() !== 200) {
            return false;
        }

        return true;
    }

    protected function isFollowing()
    {
        $user = Auth::user();

        $options = [
            'headers' => [
                'Accept' => 'application/vnd.twitchtv.v5+json',
                'Client-ID' => env('TWITCH_KEY'),
                'Authorization' => 'OAuth ' . $user->twitch_token,
            ],
            'exceptions' => false,
        ];

        $client = new Client(['base_uri' => 'https://api.twitch.tv/kraken/']);
        $response = $client->request(
            'GET',
            'users/' . $user->twitch_id . '/follows/channels/' . env('MY_CHANNEL_ID'),
            $options
        );
        if ($response->getStatusCode() !== 200) {
            return false;
        }

        return true;
    }
}
