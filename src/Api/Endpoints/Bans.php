<?php

declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api\Endpoints;

use Azuriom\Plugin\Battlemetrics\Api\Resources\ApiResourceInterface;
use Azuriom\Plugin\Battlemetrics\Api\Resources\Ban;
use Azuriom\Plugin\Battlemetrics\Api\Resources\Player;
use Illuminate\Support\Collection;

final class Bans extends EndpointAbstract implements EndpointInterface
{
    protected string $path = 'bans';

    public function path(): string
    {
        return $this->path;
    }

    public function resourceObject(): ApiResourceInterface
    {
        return new Ban($this->client);
    }

    public function create(array $data = [], array $filters = []): ApiResourceInterface
    {
        return $this->restCreate($data, $filters);
    }

    public function get(string $id, array $filters = []): ApiResourceInterface
    {
        return $this->restRead($id, $filters);
    }

    public function list(array $filters = []): Collection
    {
        return $this->restList($filters);
    }

    public function update(string $id, array $body = []): ApiResourceInterface
    {
        return $this->restUpdate($id, $body);
    }

    public function delete(string $id, array $body = []): void
    {
        $this->restDelete($id, $body);
    }
}
