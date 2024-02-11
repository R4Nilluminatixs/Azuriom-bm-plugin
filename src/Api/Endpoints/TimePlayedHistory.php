<?php

namespace Azuriom\Plugin\Battlemetrics\Api\Endpoints;

use Azuriom\Plugin\Battlemetrics\Api\Exceptions\ApiMissingRequiredParametersException;
use Azuriom\Plugin\Battlemetrics\Api\Resources\ApiResourceInterface;
use Azuriom\Plugin\Battlemetrics\Api\Resources\TimePlayedHistory as TimePlayedHistoryResource;

final class TimePlayedHistory extends EndpointAbstract implements EndpointInterface
{
    protected string $path = 'players_time-played-history';

    public function path(): string
    {
        return $this->path;
    }

    public function resourceObject(): ApiResourceInterface
    {
        return new TimePlayedHistoryResource($this->client);
    }

    public function create(array $data = [], array $filters = []): ApiResourceInterface
    {
        return $this->restCreate($data, $filters);
    }

    public function get(string $id, array $filters = []): ApiResourceInterface
    {
        if (! array_key_exists('start', $filters) || ! array_key_exists('stop', $filters)) {
            throw new ApiMissingRequiredParametersException('Time played history endpoint requires both \'start\' and \'stop\' filters to be set.');
        }

        return $this->restRead($id, $filters);
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
