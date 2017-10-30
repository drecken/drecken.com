<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $options = [
                'headers' => [
                    'Accept' => 'application/vnd.twitchtv.v5+json',
                    'Client-ID' => env('TWITCH_KEY'),
                    'Authorization' => 'OAuth ' . Auth::user()->twitch_token,
                ],
                'exceptions' => false,
            ];

            $client = new Client(['base_uri' => 'https://api.twitch.tv/kraken/']);
            $response = $client->request('GET',
                '',
                $options);

            if (!$this->isValid($response)) {
                // try refreshing the token and check again
                return redirect()->route('logout');
            }
        }

        return $next($request);
    }

    protected function isValid($response)
    {
        if ($response->getStatusCode() !== 200) {
            return false;
        }
        $body = $response->getBody();
        $object = (json_decode((string)$body));
        if ($object->token->valid !== true) {
            return false;
        }
        if (count($object->token->authorization->scopes) === 0) {
            return false;
        }

        return true;
    }
}
