<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Events;

use Azuriom\Plugin\Battlemetrics\Models\BMBan;
use Illuminate\Queue\SerializesModels;

class BMBanCreated
{
    use SerializesModels;

    public function __construct(public readonly BMBan $ban)
    {
    }
}
