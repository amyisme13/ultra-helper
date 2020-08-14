<?php

namespace Amyisme13\UltraHelper;

use Amyisme13\UltraHelper\Exceptions\AuthFailedException;
use Amyisme13\UltraHelper\Exceptions\UltraErrorException;
use Illuminate\Routing\Exceptions\InvalidSignatureException;
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
     * Generate signature hash for Ultra API
     *
     * @return string
     */
    public function generateSignature()
    {
        $signatureKey = config('ultra-helper.signature_key');
        return sha1($signatureKey . now()->format('Y-m-d'));
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

    /**
     * Get users from Ultra.
     *
     * @param int $page
     * @return \Illuminate\Support\Collection
     */
    public function getUsersPaginated(int $page = 1)
    {
        $url = $this->getUrl('users/get_users');
        $signature = $this->generateSignature();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->get($url, compact('page', 'signature'));

        if ($response->clientError()) {
            throw new InvalidSignatureException();
        } else if ($response->serverError()) {
            throw new UltraErrorException();
        }

        return collect($response->json()['data']['data']);
    }

    /**
     * Get pagination meta of users list.
     *
     * @param int $page
     * @return \Amyisme13\UltraHelper\Contracts\UsersPaginationData
     */
    public function getUsersMeta()
    {
        $url = $this->getUrl('users/get_users');
        $page = 1;
        $signature = $this->generateSignature();

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->get($url, compact('page', 'signature'));

        if ($response->clientError()) {
            throw new InvalidSignatureException();
        } else if ($response->serverError()) {
            throw new UltraErrorException();
        }

        return (object) $response->json()['data']['meta'];
    }
}
