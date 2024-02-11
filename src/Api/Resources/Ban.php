<?php

declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Api\Resources;

class Ban extends BaseResource implements ApiResourceInterface
{
    public ?int $battlemetrics_user_id;

    public int $organization_id;

    public int $battlemetrics_id;

    public ?string $steam_id;

    public string $timestamp;

    public string $reason;

    public ?string $note;

    public ?string $expires_at;

    public string $identifiers;

    public bool $organization_wide;

    public bool $auto_add_enabled;

    public bool $nativeEnabled = false;

    public function toArray(): array
    {
        return [
            'battlemetrics_user_id' => $this->battlemetrics_user_id,
            'organization_id' => $this->organization_id,
            'steam_id' => $this->steam_id,
            'timestamp' => $this->timestamp,
            'reason' => $this->reason,
            'note' => $this->note,
            'expires_at' => $this->expires_at,
            'identifiers' => $this->identifiers,
            'organization_wide' => $this->organization_wide,
            'auto_add_enabled' => $this->auto_add_enabled,
            'native_enabled' => $this->nativeEnabled,
        ];
    }

    public function fromApiRequest(array $data): self
    {
        // Sometimes we get $data['data'][...] and sometimes its $data[...]
        if (array_key_exists('data', $data)) {
            $data = $data['data'];
        }

        $self = new self($this->client);
        $self->battlemetrics_user_id = array_key_exists('player', $data['relationships'])
            ? (int) $data['relationships']['player']['data']['id']
            : null;
        $self->organization_id = (int) $data['relationships']['organization']['data']['id'];
        $self->battlemetrics_id = (int) $data['id'];
        $self->steam_id = null;
        $self->timestamp = $data['attributes']['timestamp'];
        $self->reason = $data['attributes']['reason'];
        $self->note = empty($data['attributes']['note']) ? null : $data['attributes']['note'];
        $self->expires_at = $data['attributes']['expires'];
        $self->identifiers = json_encode($data['attributes']['identifiers'], JSON_THROW_ON_ERROR);
        $self->organization_wide = $data['attributes']['orgWide'];
        $self->auto_add_enabled = $data['attributes']['autoAddEnabled'];
        $self->nativeEnabled = empty($data['attributes']['nativeEnabled']) ? false : $data['attributes']['nativeEnabled'];

        /**
         * No BattleMetrics user connection found in the return?
         * Let's try to find a steam ID in the identifiers array.
         */
        if ($self->battlemetrics_user_id === null) {
            foreach ($data['attributes']['identifiers'] as $identifier) {
                if ($identifier['type'] === 'steamID') {
                    $self->steam_id = $identifier['identifier'];
                }
            }
        }

        return $self;
    }
}

