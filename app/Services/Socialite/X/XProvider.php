<?php

namespace App\Services\Socialite\X;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class XProvider extends AbstractProvider
{
    protected $scopeSeparator = ' ';

    protected $scopes = [
        'tweet.read',
        'users.read',
        'users.email',
        'offline.access',
    ];

    /**
     * Authorization URL
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://twitter.com/i/oauth2/authorize',
            $state
        );
    }

    /**
     * Token URL
     */
    protected function getTokenUrl()
    {
        return 'https://api.twitter.com/2/oauth2/token';
    }

    /**
     * Generate PKCE challenge + save verifier
     */
    protected function getCodeFields($state = null)
    {
        $verifier = Str::random(64);
        session(['x_pkce_verifier' => $verifier]);

        $challenge = rtrim(strtr(
            base64_encode(hash('sha256', $verifier, true)),
            '+/',
            '-_'
        ), '=');

        return array_merge(parent::getCodeFields($state), [
            'code_challenge'        => $challenge,
            'code_challenge_method' => 'S256',
        ]);
    }

    /**
     * Token exchange parameters for Confidential Client:
     * ❗ NO client_secret in body (only in Basic Auth)
     */
    protected function getTokenFields($code)
    {
        return [
            'grant_type'    => 'authorization_code',
            'client_id'     => $this->clientId,
            'redirect_uri'  => $this->redirectUrl,
            'code'          => $code,
            'code_verifier' => session('x_pkce_verifier'),
        ];
    }

    /**
     * Exchange authorization code for an access token
     */
    public function getAccessTokenResponse($code)
    {
        $verifier = session('x_pkce_verifier');

        $basicAuth = base64_encode(
            urlencode($this->clientId) . ':' . urlencode($this->clientSecret)
        );

        try {
            $response = $this->getHttpClient()->post($this->getTokenUrl(), [
                'headers' => [
                    'Authorization' => 'Basic ' . $basicAuth,
                    'Content-Type'  => 'application/x-www-form-urlencoded',
                    'Accept'        => 'application/json',
                ],
                'form_params' => $this->getTokenFields($code),
            ]);

            $data = json_decode((string)$response->getBody(), true);

            session()->forget('x_pkce_verifier');

            return $data;
        } catch (RequestException $e) {

            Log::error('X Token Exchange Failed', [
                'message'  => $e->getMessage(),
                'response' => $e->hasResponse()
                    ? (string)$e->getResponse()->getBody()
                    : null,
            ]);

            throw $e;
        }
    }

    /**
     * Get authenticated user's data
     */
    protected function getUserByToken($token)
    {
        try {
            $response = $this->getHttpClient()->get(
                'https://api.twitter.com/2/users/me?user.fields=profile_image_url,name,username,verified',
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept'        => 'application/json',
                    ],
                ]
            );

            return json_decode((string)$response->getBody(), true);
        } catch (RequestException $e) {
            Log::error('X Fetch User Failed', [
                'message'  => $e->getMessage(),
                'response' => $e->hasResponse()
                    ? (string)$e->getResponse()->getBody()
                    : null,
            ]);
            throw $e;
        }
    }


    /**
     * Map X user -> Socialite User
     */
    protected function mapUserToObject(array $user)
    {
        $data = $user['data'] ?? [];

        // Email mungkin tidak ada di data; periksa root-level juga
        $email = $data['email'] ?? $user['email'] ?? null;

        return (new User())->setRaw($user)->map([
            'id'       => $data['id'] ?? null,
            'nickname' => $data['username'] ?? null,
            'name'     => $data['name'] ?? null,
            'email'    => $email,
            'avatar'   => $data['profile_image_url'] ?? null,
        ]);
    }
}
