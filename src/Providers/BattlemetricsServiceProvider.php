<?php

namespace Azuriom\Plugin\Battlemetrics\Providers;

use Azuriom\Extensions\Plugin\BasePluginServiceProvider;
use Azuriom\Models\Permission;
use Azuriom\Plugin\Battlemetrics\Api\ApiClient;
use Azuriom\Plugin\Battlemetrics\View\Composers\BattlemetricsAdminDashboardComposer;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\View;

class BattlemetricsServiceProvider extends BasePluginServiceProvider
{
    /**
     * The plugin's global HTTP middleware stack.
     */
    protected array $middleware = [
        // \Azuriom\Plugin\Battlemetrics\Middleware\ExampleMiddleware::class,
    ];

    /**
     * The plugin's route middleware groups.
     */
    protected array $middlewareGroups = [];

    /**
     * The plugin's route middleware.
     */
    protected array $routeMiddleware = [
        // 'example' => \Azuriom\Plugin\Battlemetrics\Middleware\ExampleRouteMiddleware::class,
    ];

    /**
     * The policy mappings for this plugin.
     *
     * @var array<string, string>
     */
    protected array $policies = [
        // User::class => UserPolicy::class,
    ];

    /**
     * Register any plugin services.
     */
    public function register(): void
    {
        $this->app->singleton(ApiClient::class);
        $this->app->register(BattlemetricsEventServiceProvider::class);
    }

    /**
     * Bootstrap any plugin services.
     */
    public function boot(): void
    {
        // $this->registerPolicies();

        $this->loadViews();

        $this->loadTranslations();

        $this->loadMigrations();

        $this->registerRouteDescriptions();

        $this->registerAdminNavigation();

        $this->registerUserNavigation();

        // Expose admin dashboard card.
        View::composer('admin.dashboard', BattlemetricsAdminDashboardComposer::class);

        // Register BattleMetrics admin permission.
        Permission::registerPermissions(['battlemetrics.admin' => 'battlemetrics::admin.permissions.admin']);

        // Fully sync all BattleMetrics bans every hour to remain in sync,
        // but avoid hammering the BattleMetrics API too much.
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            $schedule->command('bm:full-sync')->hourly();
        });
    }

    /**
     * Returns the routes that should be able to be added to the navbar.
     *
     * @return array<string, string>
     */
    protected function routeDescriptions(): array
    {
        return [
            'battlemetrics.index' => trans('battlemetrics::user.banlist.title'),
        ];
    }

    /**
     * Return the admin navigations routes to register in the dashboard.
     *
     * @return array<string, array<string, string>>
     */
    protected function adminNavigation(): array
    {
        return [
            'battlemetrics' => [
                'name' => trans('battlemetrics::admin.nav.title'),
                'type' => 'dropdown',
                'icon' => 'bi bi-search',
                'route' => 'battlemetrics.admin.*',
                'permissions' => 'battlemetrics.admin',
                'items' => [
                    'battlemetrics.admin.settings' => trans('battlemetrics::admin.nav.settings'),
                    'battlemetrics.admin.bans' => trans('battlemetrics::admin.nav.ban_list'),
                ],
            ],
        ];
    }

    /**
     * Return the user navigations routes to register in the user menu.
     *
     * @return array<string, array<string, string>>
     */
    protected function userNavigation(): array
    {
        return [
            //
        ];
    }
}
