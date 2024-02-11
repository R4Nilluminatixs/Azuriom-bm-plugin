<?php

namespace Azuriom\Plugin\Battlemetrics\Console\Commands;

use Azuriom\Models\ActionLog;
use Azuriom\Plugin\Battlemetrics\Events\FullBanSyncRequested;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Event;

class FullSyncBansCommand extends Command
{
    protected $signature = 'bm:full-sync';

    protected $description = 'Fully sync BattleMetrics bans with Azuriom.';

    public function handle(): void
    {
        Event::dispatch(new FullBanSyncRequested());
    }
}
