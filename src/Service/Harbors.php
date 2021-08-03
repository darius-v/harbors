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

        $harborsFromApi = json_decode($harborsJson, true);

        $harbors = [];

        foreach ($harborsFromApi as $harborFromApi) {
            $harbor = [];
            $harbor['name'] = $harborFromApi['name'];
            if (isset($harborFromApi['image'])) {
                $harbor['image'] = $harborFromApi['image'];
            }

            $harbor['weather'] = 'todo';

            $harbors[] = $harbor;
        }

        return $harbors;
    }
}