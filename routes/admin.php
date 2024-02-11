<?php

use Azuriom\Plugin\Battlemetrics\Controllers\Admin\BansController;
use Azuriom\Plugin\Battlemetrics\Controllers\Admin\SettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::middleware('can:battlemetrics.admin')->group(function () {
    Route::get('/settings', [SettingsController::class, 'show'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'save'])->name('settings.save');

    Route::get('/bans', [BansController::class, 'list'])->name('bans');
    Route::get('/bans/sync', [BansController::class, 'syncAll'])->name('bans.sync.all');
    Route::get('/bans/{ban}', [BansController::class, 'show'])->name('bans.show');
    Route::get('/bans/{ban}/sync', [BansController::class, 'sync'])->name('bans.sync');
});
