<?php

namespace App\Tests\Service;

use App\Service\ApiClient;
use App\Service\Harbors;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Router;

class HarborsTest extends TestCase
{
    /**
     * @dataProvider provideList
     */
    public function testList(array $expected, array $harborsApiData)
    {
        $harbors = new Harbors(
            $this->mockApiClient(json_encode($harborsApiData)),
            'b4b6cf42d49ae20d5a439454b8e19c1c',
            $this->mockRouter()
        );

        $list = $harbors->harborsList();

        $this->assertEquals($expected, $list);
    }

    private function mockApiClient(string $output)
    {
        $mock = $this->createMock(ApiClient::class);

        $mock
            ->method('fetch')
            ->willReturn($output)
        ;

        return $mock;
    }

    private function mockRouter()
    {
        $mock = $this->createMock(Router::class);

        $mock
            ->method('generate')
            ->willReturn("/harbor/fccf6889-c4c6-4ab0-9bfa-21c54b25d17d")
        ;

        return $mock;
    }

    public function provideList(): array
    {
        return [
            'Image exists' => [
                'expected' => [
                    ['name' => 'name', 'image' => '/uploads/bla.jpg', 'weatherUrl' => '/harbor/fccf6889-c4c6-4ab0-9bfa-21c54b25d17d'],
                ],
                [
                    [
                        'id' => 'asd',
                        'name' => 'name',
                        'image' => '/uploads/bla.jpg',
                        'lat' => '54.9',
                        'lon' => '54.8',
                        'isPriceHidden' => false,
                        'isFree' => false,
                        'canBook' => true,
                        'cashOnlyBookings' => false,
                        'notActivated' => false,
                        'translations' => [],
                        'acceptBankPayments' => true,
                        'acceptEpayPayments' => true,
                        'acceptGoCardlessPayments' => true,
                        'acceptBankPaymentsIban' => true,
                        'bookOneDayOnly' => false,
                    ]
                ]
            ],
            'Image does not exist' => [
                'expected' => [
                    ['name' => 'name', 'weatherUrl' => '/harbor/fccf6889-c4c6-4ab0-9bfa-21c54b25d17d'],
                ],
                [
                    [
                        'id' => 'asd',
                        'name' => 'name',
                        'lat' => '54.9',
                        'lon' => '54.8',
                        'isPriceHidden' => false,
                        'isFree' => false,
                        'canBook' => true,
                        'cashOnlyBookings' => false,
                        'notActivated' => false,
                        'translations' => [],
                        'acceptBankPayments' => true,
                        'acceptEpayPayments' => true,
                        'acceptGoCardlessPayments' => true,
                        'acceptBankPaymentsIban' => true,
                        'bookOneDayOnly' => false,
                    ]
                ]
            ]
        ];
    }
}