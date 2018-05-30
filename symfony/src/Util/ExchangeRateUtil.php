<?php

namespace App\Util;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Symfony\Component\HttpFoundation\Request;

class ExchangeRateUtil
{
    const SCHEME = 'http://';
    const HOST = 'free.currencyconverterapi.com';
    const PATH = '/api/v5/convert';

    /**
     * @var Client
     */
    private $client;

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $from
     * @param string $to
     * @return float
     */
    public function get(string $from, string $to): float
    {
        $rateKey = $from . '_' . $to;
        $query = http_build_query([
            'q' => $rateKey,
            'compact' => 'y'
        ]);

        $response = $this->client
            ->request(Request::METHOD_GET, self::SCHEME . self::HOST . self::PATH . '?' . $query);
        $result = json_decode($response->getBody(), true);

        if(empty($result)) {
            throw new \InvalidArgumentException('Invalid arguments have been passed.');
        }

        return $result[$rateKey]['val'];
    }
}