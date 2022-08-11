<?php

namespace App\Service;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class HttpClientConnector
{

    /**
     * @throws TransportExceptionInterface
     */
    public function urlConnect(string $url): ResponseInterface
    {
        $client = HttpClient::create();
        $response = $client->request('GET', $url);

        if (200 !== $response->getStatusCode()) {
            throw new Exception('Failed to connect to the url ' .$url);
        }

        return $response;
    }
}