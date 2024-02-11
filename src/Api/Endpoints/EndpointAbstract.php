<?php

declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api\Endpoints;

use Azuriom\Plugin\Battlemetrics\Api\ApiClient;
use Azuriom\Plugin\Battlemetrics\Api\Exceptions\ApiMissingResourceIdException;
use Azuriom\Plugin\Battlemetrics\Api\Exceptions\SubResourceWithoutParentIdException;
use Azuriom\Plugin\Battlemetrics\Api\Resources\ApiResourceInterface;
use Azuriom\Plugin\Battlemetrics\Api\Resources\ResourceFactory;
use Illuminate\Support\Collection;

/**
 * Abstract class handling everything an endpoint needs to be used.
 */
abstract class EndpointAbstract
{
    public const REST_CREATE = 'POST';

    public const REST_UPDATE = 'PATCH';

    public const REST_READ = 'GET';

    public const REST_DELETE = 'DELETE';

    protected string $path;

    protected ?string $parentId;

    public function __construct(protected readonly ApiClient $client)
    {
    }

    /**
     * Function to construct path to resource on the external API.
     * Includes support for sub-resources like: players/{id}/time_history
     */
    public function getResourcePath(): string
    {
        if (! str_contains($this->path, '_')) {
            return $this->path;
        }

        [$parentResource, $childResource] = explode('_', $this->path, 2);

        if (empty($this->parentId)) {
            throw new SubResourceWithoutParentIdException("Subresource {$this->path} used without parent {$parentResource} ID.");
        }

        return "{$parentResource}/{$this->parentId}/$childResource";
    }

    public function setParentId(string $id): self
    {
        $this->parentId = $id;

        return $this;
    }

    public function parentId(): ?string
    {
        return $this->parentId;
    }

    /**
     * Definition of resource object. Ex: plugins/battlemetrics/src/Api/Resources/Player.php
     * The resource object will be used to pass data from the unstructured api response to an
     * object we can easily use further down the line.
     */
    abstract protected function resourceObject(): ApiResourceInterface;

    protected function restCreate(array $body, array $filters): ApiResourceInterface
    {
        if ($this->client->accessToken() === null) {
            $this->client->setAccessToken(setting('battlemetrics.token'));
        }

        $result = $this->client->call(
            self::REST_CREATE,
            $this->getResourcePath().$this->buildQueryString($filters),
            $this->encodeRequestBody($body)
        );

        $decodedResult = json_decode($result->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);


        return ResourceFactory::createFromApiResult($decodedResult['data'], $this->resourceObject());
    }

    protected function restUpdate(string $id, array $body = []): ApiResourceInterface
    {
        if (empty($id)) {
            throw new ApiMissingResourceIdException('Invalid resource id.');
        }

        if ($this->client->accessToken() === null) {
            $this->client->setAccessToken(setting('battlemetrics.token'));
        }

        $id = urlencode($id);
        $result = $this->client->call(
            self::REST_UPDATE,
            "{$this->getResourcePath()}/{$id}",
            $this->encodeRequestBody($body)
        );

        $decodedResult = json_decode($result->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);

        return ResourceFactory::createFromApiResult($decodedResult['data'], $this->resourceObject());
    }

    protected function restRead(string $id, array $filters): ApiResourceInterface
    {
        if (empty($id)) {
            throw new ApiMissingResourceIdException('Invalid resource id.');
        }

        if ($this->client->accessToken() === null) {
            $this->client->setAccessToken(setting('battlemetrics.token'));
        }

        $id = urlencode($id);

        $result = $this->client->call(
            self::REST_READ,
            "{$this->getResourcePath()}/{$id}".$this->buildQueryString($filters)
        );

        $decodedResult = json_decode($result->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);

        return ResourceFactory::createFromApiResult($decodedResult, $this->resourceObject());
    }

    protected function restList(array $filters): Collection
    {
        if ($this->client->accessToken() === null) {
            $this->client->setAccessToken(setting('battlemetrics.token'));
        }

        $totalSize = null;
        $bans = [];
        $url = $this->getResourcePath().$this->buildQueryString($filters);
        while ($totalSize > count($bans) || $totalSize === null) {
            $result = $this->client->call(
                self::REST_READ,
                $url,
            );

            $result = json_decode($result->getBody()->getContents(), true, flags: JSON_THROW_ON_ERROR);
            $bans = array_merge($bans, $result['data']);
            if ($totalSize === null) {
                $totalSize = $result['meta']['total'];
            }

            if (array_key_exists('next', $result['links'])) {
                $url = $result['links']['next'];
            }
        }

        $payload = new Collection();
        /** @var array $ban */
        foreach ($bans as $ban) {
            $payload->add(
                ResourceFactory::createFromApiResult($ban, $this->resourceObject())
            );
        }

        return $payload;
    }

    protected function restDelete(string $id, array $body = []): void
    {
        if (empty($id)) {
            throw new ApiMissingResourceIdException('Invalid resource id.');
        }

        if ($this->client->accessToken() === null) {
            $this->client->setAccessToken(setting('battlemetrics.token'));
        }

        $id = urlencode($id);
        $this->client->call(
            self::REST_DELETE,
            "{$this->getResourcePath()}/{$id}",
            $this->encodeRequestBody($body)
        );
    }

    /**
     * Make sure we encode the array body to a json body for
     * usage in the actual guzzle request to our external api.
     */
    protected function encodeRequestBody(array $body): ?string
    {
        if (empty($body)) {
            return null;
        }

        return json_encode($body);
    }

    /**
     * Construct query string by using $filters parameter.
     */
    protected function buildQueryString(array $filters): string
    {
        if (empty($filters)) {
            return '';
        }

        foreach ($filters as $key => $value) {
            if ($value === true) {
                $filters[$key] = 'true';
            }

            if ($value === false) {
                $filters[$key] = 'false';
            }
        }

        return '?'.http_build_query($filters, '', '&');
    }
}
