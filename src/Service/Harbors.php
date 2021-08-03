<?php

namespace App\Service;

class Harbors
{
    private ApiClient $apiClient;

    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function harborsList(): array
    {
        $harborsJson = $this->apiClient->fetch('https://devapi.harba.co/harbors/visible');

        $harbors = json_decode($harborsJson, true);

        return $harbors;
    }
}