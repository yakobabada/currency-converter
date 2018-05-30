<?php

namespace App\Tests\Util;

use App\Util\ExchangeRateUtil;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ExchangeRateUtilTest extends TestCase
{
    /**
     * @var ClientInterface
     */
    private $client;

    const HTTP_CODE_TO_CHECK = [

    ];

    public function setUp()
    {
        parent::setUp();

        $this->client = $this->createMock(Client::class);
    }

    public function testInCorrectGetCurrencyExchange()
    {
        $response = new Response(
            \Symfony\Component\HttpFoundation\Response::HTTP_OK,
            ['Content-Length' => 2],
            '{}'
        );

        $this->client->expects($this->any())
            ->method('request')
            ->willReturn($response);

        $this->expectException(\InvalidArgumentException::class);

        $webUrlCheckStatusUtil = new ExchangeRateUtil($this->client);
        $webUrlCheckStatusUtil->get('EURs', 'USD');
    }

    public function testGetCurrencyExchange()
    {
        $response = new Response(
            \Symfony\Component\HttpFoundation\Response::HTTP_OK,
            ['Content-Length' => 2],
            '{"EUR_USD":{"val":1.171507}}'
        );

        $this->client->expects($this->any())
            ->method('request')
            ->willReturn($response);

        $webUrlCheckStatusUtil = new ExchangeRateUtil($this->client);
        $exchangeRate = $webUrlCheckStatusUtil->get('EUR', 'USD');

        $this->assertEquals(1.171507, $exchangeRate);
    }
}