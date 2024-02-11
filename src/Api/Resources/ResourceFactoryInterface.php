<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api\Resources;


interface ResourceFactoryInterface
{
    public static function createFromApiResult(array $response, ApiResourceInterface $resourceObject): ApiResourceInterface;
}
