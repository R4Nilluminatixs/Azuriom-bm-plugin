<?php
declare(strict_types=1);

namespace Azuriom\Plugin\Battlemetrics\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Azuriom\Plugin\Battlemetrics\Requests\Admin\StoreSettingsRequest;
use Illuminate\Contracts\Foundation\Application as ContractFoundationApplication;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class SettingsController extends Controller
{
    public function show(): View|Application|Factory|ContractFoundationApplication
    {
        return view('battlemetrics::admin.settings', [
            'token' => setting('battlemetrics.token'),
        ]);
    }

    public function save(StoreSettingsRequest $request): RedirectResponse
    {
        Setting::updateSettings('battlemetrics.token', $request->input('token'));

        return to_route('battlemetrics.admin.settings')
            ->with('success', trans('admin.settings.updated'));
    }
}
