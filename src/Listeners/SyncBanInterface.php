<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Listeners;

use Azuriom\Plugin\Battlemetrics\Events\BanSyncRequested;
use Azuriom\Plugin\Battlemetrics\Events\FullBanSyncRequested;

interface SyncBanInterface
{
    public function handle(BanSyncRequested|FullBanSyncRequested $event): void;
}
