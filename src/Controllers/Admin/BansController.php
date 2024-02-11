<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Azuriom\Plugin\Battlemetrics\Events\BanSyncRequested;
use Azuriom\Plugin\Battlemetrics\Events\FullBanSyncRequested;
use Azuriom\Plugin\Battlemetrics\Models\BMBan;
use Azuriom\Plugin\Battlemetrics\Requests\Admin\StoreSettingsRequest;
use Illuminate\Contracts\Foundation\Application as ContractFoundationApplication;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Event;

class BansController extends Controller
{
    public function list(): View|Application|Factory|ContractFoundationApplication
    {
        return view('battlemetrics::admin.bans.index', [
            'bans' => BMBan::query()->with('user')->paginate(20, [
                'id',
                'battlemetrics_id',
                'organization_id',
                'user_id',
                'steam_id',
                'reason',
                'timestamp',
                'expires_at',
            ])->withQueryString(),
        ]);
    }

    public function show(BMBan $ban): View|Application|Factory|ContractFoundationApplication
    {
        return view('battlemetrics::admin.bans.view', [
            'id' => $ban->id,
            'battlemetrics_id' => $ban->battlemetrics_id,
            'organization_id' => $ban->organization_id,
            'user' => $ban->user,
            'steam_id' => $ban->steam_id,
            'reason' => $ban->reason,
            'note' => $ban->note ?? trans('battlemetrics::admin.ban.no_notes_added'),
            'timestamp' => $ban->timestamp->format('Y-m-d H:i:s'),
            'expires_at' => $ban->expires_at ? $ban->expires_at->format('Y-m-d H:i:s') : trans('battlemetrics::admin.ban.permanently_banned'),
            'identifiers' => $ban->identifiers,
            'organization_wide' => $ban->organization_wide,
            'auto_add_enabled' => $ban->auto_add_enabled,
            'native_enabled' => $ban->native_enabled,
            'last_sync' => $ban->last_sync ? $ban->last_sync->format('Y-m-d H:i:s') : '-',
        ]);
    }

    public function sync(BMBan $ban): RedirectResponse
    {
        Event::dispatch(new BanSyncRequested($ban));

        return redirect()->back()->with(
            'success',
            trans('battlemetrics::admin.ban.messages.synced_success')
        );
    }

    public function syncAll(): RedirectResponse
    {
        Event::dispatch(new FullBanSyncRequested());

        return redirect()->back()->with(
            'success',
            trans('battlemetrics::admin.ban.messages.synced_success')
        );
    }
}
