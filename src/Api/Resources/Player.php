<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api\Resources;

use Azuriom\Plugin\Battlemetrics\Api\Endpoints\TimePlayedHistory;

class Player extends BaseResource implements ApiResourceInterface
{
    public string $id;

    public string $type;

    public string $name;

    public string $steamId;

    public array $organizations;

    public function fromApiRequest(array $data): self
    {
        $self = new self($this->client);
        $self->id = $data['data']['id'];
        $self->type = $data['data']['type'];
        $self->name = $data['data']['attributes']['name'];
        $self->organizations = $data['data']['relationships']['organizations']['data'];

        foreach ($data['included'] as $include) {
            if ($include['attributes']['type'] === 'steamID') {
                $self->steamId = $include['attributes']['identifier'];
            }
        }

        return $self;
    }
}
