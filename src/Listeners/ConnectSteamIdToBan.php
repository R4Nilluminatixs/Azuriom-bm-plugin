<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Listeners;

use Azuriom\Plugin\Battlemetrics\Api\ApiClient;
use Azuriom\Plugin\Battlemetrics\Api\Endpoints\Players;
use Azuriom\Plugin\Battlemetrics\Api\Resources\Player;
use Azuriom\Plugin\Battlemetrics\Events\BMBanCreated;
use Azuriom\Plugin\Battlemetrics\Events\BMBanUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConnectSteamIdToBan implements ShouldQueue
{
    public function __construct(private readonly ApiClient $client)
    {
    }

    public function handle(BMBanCreated|BMBanUpdated $event): void
    {
        if ($event->ban->steam_id !== null) {
            return;
        }

        if ($event->ban->battlemetrics_user_id === null) {
            return;
        }

        $battleMetricsUserId = $event->ban->battlemetrics_user_id ? (string) $event->ban->battlemetrics_user_id : null;

        $playersEndpoint = new Players($this->client);
        /** @var Player $result */
        $result = $playersEndpoint->get($battleMetricsUserId, ['include' => 'identifier']);

        if ($result->steamId === null) {
            return; // Couldn't find a steam ID connected to the ban..
        }

        $event->ban->steam_id = $result->steamId;
        $event->ban->save();
    }
}