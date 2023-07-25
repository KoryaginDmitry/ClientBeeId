<?php

namespace App\Services\BeeOnline;

class BeeOnlineBaseService
{
    protected string $url;

    /**
     * Хранит маршруты api bee-online
     *
     * @var array
     */
    protected array $urls = [
        'updateUser' => 'api/user/update'
    ];

    public function __construct()
    {
        $this->url = config('services.bee_id.url');
    }

    /**
     * Формирует url для запроса
     *
     * @param string $urlType
     * @return string
     */
    protected function getUrl(string $urlType): string
    {
        return $this->url . '/' . $this->urls[$urlType];
    }
}
