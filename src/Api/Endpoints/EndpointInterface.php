<?php

declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api\Endpoints;

use Azuriom\Plugin\Battlemetrics\Api\Resources\ApiResourceInterface;

interface EndpointInterface
{
    public function path(): string;

    public function parentId(): ?string;

    public function resourceObject(): ApiResourceInterface;
}
