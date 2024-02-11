<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api\Resources;

use Azuriom\Plugin\Battlemetrics\Api\ApiClient;

abstract class BaseResource
{
    public function __construct(protected readonly ApiClient $client)
    {
    }
}
