<?php

namespace Azuriom\Plugin\Battlemetrics\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Battlemetrics\Models\BMBan;
use DateTime;
use Illuminate\Contracts\Foundation\Application as ContractApplication;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class BattlemetricsHomeController extends Controller
{
    /**
     * Show the home plugin page.
     */
    public function index(): View|Application|Factory|ContractApplication
    {
        $bans = BMBan::query()
            ->where('expires_at', '>=', new DateTime())
            ->orWhereNull('expires_at')
            ->whereNotNull('steam_id')
            ->paginate(
                10,
                [
                    'steam_id',
                    'timestamp',
                    'reason',
                    'expires_at',
                    'organization_wide',
                ]
            );

        return view('battlemetrics::index', [
            'bans' => $bans,
        ]);
    }
}
ans,
        ]);
    }
}
