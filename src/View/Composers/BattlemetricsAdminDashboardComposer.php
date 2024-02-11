<?php

declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\View\Composers;

use Azuriom\Extensions\Plugin\AdminDashboardCardComposer;
use Azuriom\Plugin\Battlemetrics\Models\BMBan;
use Illuminate\Support\Facades\Gate;

class BattlemetricsAdminDashboardComposer extends AdminDashboardCardComposer
{
    public function getCards(): array
    {
        if (! Gate::allows('battlemetrics.admin')) {
            return [];
        }

        return [
            'battlemetrics_bans' => [
                'color' => 'danger',
                'name' => trans('battlemetrics::admin.dashboard.card'),
                'value' => BMBan::activeBansCount().' / '.BMBan::totalBansCount(),
                'icon' => 'bi bi-person-x',
            ],
        ];
    }
}
