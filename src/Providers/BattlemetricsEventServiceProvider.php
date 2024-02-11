<?php

declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Providers;

use Azuriom\Plugin\Battlemetrics\Events\BanSyncRequested;
use Azuriom\Plugin\Battlemetrics\Events\BMBanCreated;
use Azuriom\Plugin\Battlemetrics\Events\BMBanUpdated;
use Azuriom\Plugin\Battlemetrics\Events\FullBanSyncRequested;
use Azuriom\Plugin\Battlemetrics\Listeners\ConnectSteamIdToBan;
use Azuriom\Plugin\Battlemetrics\Listeners\SyncBans;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class BattlemetricsEventServiceProvider extends EventServiceProvider
{
    protected $listen = [
        BanSyncRequested::class => [
            SyncBans::class,
        ],
        FullBanSyncRequested::class => [
            SyncBans::class,
        ],
        BMBanCreated::class => [
            ConnectSteamIdToBan::class,
        ],
        BMBanUpdated::class => [
            ConnectSteamIdToBan::class,
        ],
    ];
}
