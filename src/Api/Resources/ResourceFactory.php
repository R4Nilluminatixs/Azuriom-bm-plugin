<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api\Resources;

final class ResourceFactory implements ResourceFactoryInterface
{
    public static function createFromApiResult(array $response, ApiResourceInterface $resourceObject): ApiResourceInterface
    {
        return $resourceObject->fromApiRequest($response);
    }
}
