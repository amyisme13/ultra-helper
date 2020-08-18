<?php

namespace Amyisme13\UltraHelper;

use Amyisme13\UltraHelper\Exceptions\AuthFailedException;
use Amyisme13\UltraHelper\Exceptions\InvalidSignatureException;
use Amyisme13\UltraHelper\Exceptions\UltraErrorException;
use Amyisme13\UltraHelper\Exceptions\ValidationException;
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
     * Get full valid point url
     *
     * @param string $path
     * @return string
     */
    private function getPointUrl($path)
    {
        $baseUrl = config('ultra-helper.point_url');
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
     * Login using encrypted token
     *
     * @param string $token
     * @return \Amyisme13\UltraHelper\Contracts\AuthUserData
     */
    public function loginWithToken($token)
    {
        $data = Encryption::decrypt($token);
        if (!$data) {
            throw new AuthFailedException('Invalid token');
        }

        $json = json_decode($data);
        if ($json->timeCreated < now()->subHour()->timestamp) {
            throw new AuthFailedException('Token expired');
        }

        return (object) [
            'id' => $json->id,
            'username' => $json->username,
            'email' => $json->email,
            'name' => $json->fullname,
        ];
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

    /**
     * Add point to the given user.
     *
     * @param string $name
     * @param string $username
     * @param int $point
     * @param string $event
     * @return \Amyisme13\UltraHelper\Contracts\PointResponseData
     */
    public function addPoint($name, $username, $point, $event = '')
    {
        $url = $this->getPointUrl('add');
        $user = config('ultra-helper.point_user');
        $password = config('ultra-helper.point_password');

        if (empty($event)) {
            $event = config('ultra-helper.point_event_name');
        }

        $response = Http::withBasicAuth($user, $password)
            ->post($url, [
                'full_name' => $name,
                'nik' => $username,
                'point' => $point,
                'event' => $event,
            ]);

        if ($response->clientError()) {
            throw new ValidationException($response['errors']);
        } else if ($response->serverError()) {
            throw new UltraErrorException();
        }

        return (object) $response->json();
    }

    /**
     * Reset point of event.
     *
     * @param string $event
     * @return \Amyisme13\UltraHelper\Contracts\PointResponseData
     */
    public function resetPoint($event = '')
    {
        $url = $this->getPointUrl('reset');
        $user = config('ultra-helper.point_user');
        $password = config('ultra-helper.point_password');

        if (empty($event)) {
            $event = config('ultra-helper.point_event_name');
        }

        $response = Http::withBasicAuth($user, $password)
            ->post($url, ['event' => $event]);

        if ($response->clientError()) {
            throw new ValidationException($response['errors']);
        } else if ($response->serverError()) {
            throw new UltraErrorException();
        }

        return (object) $response->json();
    }
}
