<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Listeners;

use Azuriom\Models\User;
use Azuriom\Plugin\Battlemetrics\Api\ApiClient;
use Azuriom\Plugin\Battlemetrics\Api\Endpoints\Bans;
use Azuriom\Plugin\Battlemetrics\Api\Resources\Ban;
use Azuriom\Plugin\Battlemetrics\Events\BanSyncRequested;
use Azuriom\Plugin\Battlemetrics\Events\FullBanSyncRequested;
use Azuriom\Plugin\Battlemetrics\Models\BMBan;
use Carbon\Carbon;

final class SyncBans implements SyncBanInterface
{
    public function __construct(private readonly ApiClient $client)
    {
    }

    public function handle(FullBanSyncRequested|BanSyncRequested $event): void
    {
        $banApiEndpoint = new Bans($this->client);

        if ($event instanceof BanSyncRequested) {
            /** @var Ban $result */
            $result = $banApiEndpoint->get((string) $event->ban->battlemetrics_id);
            $this->updateOrCreateBMBan($result);

            return;
        }

        $result = $banApiEndpoint->list(['page' => ['size' => 100]]);
        $result->each(function (Ban $ban) {
            $this->updateOrCreateBMBan($ban);
        });
    }

    private function updateOrCreateBMBan(Ban $ban): void
    {
        $updateArray = array_merge($ban->toArray(), ['last_sync' => new Carbon()]);

        /** @var User $matchedUser */
        $matchedUser = User::query()->where('game_id', $ban->steam_id)->first(['id']);
        if ($matchedUser instanceof User && $matchedUser->exists) {
            $updateArray['user_id'] = $matchedUser->id;
        }

        BMBan::updateOrCreate(['battlemetrics_id' => $ban->battlemetrics_id], $updateArray);
    }
}
