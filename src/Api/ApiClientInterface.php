<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api;

use GuzzleHttp\Psr7\Response;

interface ApiClientInterface
{
    public function accessToken(): ?string;
    public function setAccessToken(string $accessToken): self;
    public function call(string $httpMethod, string $url, ?string $httpBody = null): Response;
}
