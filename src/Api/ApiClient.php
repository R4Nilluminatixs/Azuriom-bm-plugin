<?php

declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api;

use Azuriom\Plugin\Battlemetrics\Api\Exceptions\ApiCredentialsException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

final class ApiClient implements ApiClientInterface
{
    /**
     * Prefix of the api routes used by the Endpoint objects.
     */
    public const API_ENDPOINT = 'https://api.battlemetrics.com';

    protected string $accessToken;

    public function __construct(private readonly Client $client)
    {
    }

    public function accessToken(): ?string
    {
        if (empty($this->accessToken)) {
            return null;
        }

        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): self
    {
        $this->accessToken = trim($accessToken);

        return $this;
    }

    public function call(string $httpMethod, string $url, ?string $httpBody = null): Response
    {
        if (empty($this->accessToken)) {
            throw new ApiCredentialsException('You have not set an access token.. Please use setAccessToken() before calling this function.');
        }

        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            $url = self::API_ENDPOINT.'/'.$url;
        }

        $requestOptions = [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => "Bearer {$this->accessToken}",
            ],
        ];

        if ($httpBody !== null) {
            $requestOptions['headers']['Content-Type'] = 'application/json';
            $requestOptions['body'] = $httpBody;
        }

        return $this->client->request($httpMethod, $url, $requestOptions);
    }
}