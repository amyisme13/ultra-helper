<?php

namespace Amyisme13\UltraHelper;

use Amyisme13\UltraHelper\Exceptions\AuthFailedException;
use Amyisme13\UltraHelper\Exceptions\UltraErrorException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UltraHelper
{
    /**
     * Get full valid url
     *
     * @param string $path
     * @return string
     */
    private function getUrl($path)
    {
        $baseUrl = config('ultra-helper.url');
        if (!Str::endsWith($baseUrl, '/')) {
            $baseUrl .= '/';
        }

        return $baseUrl . $path;
    }

    /**
     * Login using username and password
     *
     * @param string $username
     * @param string $password
     * @return \Amyisme13\UltraHelper\Contracts\AuthUserData
     */
    public function login($username, $password)
    {
        $url = $this->getUrl('users/auth');
        $response = Http::post($url, compact('username', 'password'));

        if ($response->clientError()) {
            throw new AuthFailedException(trim($response['data']));
        } else if ($response->serverError()) {
            throw new UltraErrorException();
        }

        return (object) $response->json()['data'];
    }
}
