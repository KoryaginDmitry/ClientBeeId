<?php

namespace App\Services\BeeOnline;

use App\Models\User;
use Illuminate\Support\Facades\Http;

class UserService extends BeeOnlineBaseService
{
    /**
     * Отправляет запрос на обновление пользователя на Bee-online
     *
     * @param User $user
     * @param array $data
     * @return void
     */
    public function updateUser(User $user, array $data)
    {
        Http::acceptJson()
            ->withToken($user->access_token)
            ->put($this->getUrl('updateUser'), $data)
            ->throw();
    }
}
