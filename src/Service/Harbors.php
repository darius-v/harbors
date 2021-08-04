<?php

namespace App\Service;

use JetBrains\PhpStorm\ArrayShape;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

class Harbors
{
    private const WEATHER_PROVIDER_DOMAIN = 'https://api.openweathermap.org';

    private string $weatherApiKey;

    public function __construct(private ApiClient $apiClient, string $weatherApiKey, private RouterInterface $router)
    {
        $this->weatherApiKey = $weatherApiKey;
    }

    public function harborsList(): array
    {
        $harborsFromApi = $this->fetchHarbors();

        $harbors = [];

        foreach ($harborsFromApi as $harborFromApi) {
            $harbor = [];
            $harbor['name'] = $harborFromApi['name'];
            if (isset($harborFromApi['image'])) {
                $harbor['image'] = $harborFromApi['image'];
            }

            $harbor['weather'] = $this->router->generate('harbor_weather', ['harborId' => $harborFromApi['id']]);

            $harbors[] = $harbor;
        }

        return $harbors;
    }

    #[ArrayShape(['name' => "string", 'weather' => "array", 'weather_provider' => "string"])]
    public function getHarborWeather(string $id): array
    {
        $harbors = $this->fetchHarbors();

        $harbor = null;

        foreach ($harbors as $harborFromApi) {
            if ($harborFromApi['id'] === $id) {
                $harbor = $harborFromApi;
                break;
            }
        }

        if (null === $harbor) {
            throw new NotFoundHttpException('Harbor not found by id');
        }

        $weather = $this->apiClient->fetch(sprintf(
            self::WEATHER_PROVIDER_DOMAIN . '/data/2.5/weather?lat=%d&lon=%d&appid=' . $this->weatherApiKey,
            $harbor['lat'],
            $harbor['lon'],
        ));

        return [
            'name' => $harbor['name'],
            'weather' => json_decode($weather, true) ,
            'weather_provider' => self::WEATHER_PROVIDER_DOMAIN,
        ];
    }

    private function fetchHarbors(): array
    {
        $harborsJson = $this->apiClient->fetch('https://devapi.harba.co/harbors/visible');

        return json_decode($harborsJson, true);
    }
}