<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Events;

use Azuriom\Plugin\Battlemetrics\Models\BMBan;
use Illuminate\Queue\SerializesModels;

class BanSyncRequested
{
    use SerializesModels;

    public BMBan $ban;

    public function __construct(BMBan $ban)
    {
        $this->ban = $ban;
    }
}
