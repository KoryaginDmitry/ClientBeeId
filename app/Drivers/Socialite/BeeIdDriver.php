<?php

namespace App\Drivers\Socialite;

use GuzzleHttp\Exception\GuzzleException;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\User;

/**
 * Драйвер для авторизации через Bee-id
 */
class BeeIdDriver extends AbstractProvider
{
    /**
     * Запрашиваемые доступы
     *
     * @var array
     */
    protected $scopes = ['user'];

    /**
     * url сайта bee-id
     * @var string
     */
    protected string $authUrlSite;

    /**
     * Возвращает url адрес сайта авторизации
     *
     * @return string
     */
    protected function getAuthUrlSite(): string
    {
        return $this->authUrlSite ??= config('services.bee_id.url');
    }

    /**
     * Возвращает url для получения авторизации
     *
     * @param $state
     * @return string
     */
    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase($this->getAuthUrlSite() . '/oauth/authorize', $state);
    }

    /**
     * Возвращает url для получения токена
     *
     * @return string
     */
    protected function getTokenUrl(): string
    {
        return $this->getAuthUrlSite() . '/oauth/token';
    }

    /**
     * Возвращает авторизованного пользователя
     *
     * @param $token
     * @return array|mixed
     * @throws GuzzleException
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get(
            $this->getAuthUrlSite() . '/api/user',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                ],
            ]
        );

        $response = json_decode($response->getBody(), true);

        return $response['data']['user'];
    }

    /**
     * Преобразует данные пользователя в объект
     *
     * @param array $user
     * @return User
     */
    protected function mapUserToObject(array $user): User
    {
        return (new User())->setRaw($user)->map([
            'id' => $user['id'],
            'name' => $user['name'],
            'post' => $user['post'],
            'email' => $user['email'],
            'phone' => $user['phone'],
        ]);
    }

    /**
     * Запрашивает access token
     *
     * @param $code
     * @return array|mixed
     * @throws GuzzleException
     */
    public function getAccessTokenResponse($code)
    {
        $response = $this->getHttpClient()->post(
            $this->getTokenUrl(),
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'redirect_uri' => $this->redirectUrl,
                    'code' => $code,
                ],
            ]
        );

        return json_decode($response->getBody(), true);
    }
}
