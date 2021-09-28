<?php

namespace Modules\CrmAutoCar\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\BaseCore\Contracts\Services\CompositeurThemeContract;
use Modules\BaseCore\Entities\TypeView;
use Modules\CoreCRM\Contracts\Views\Dossiers\DossierAfterSidebarContract;

class CrmAutoCarServiceProvider extends ServiceProvider
{

    /**
     * @var string $moduleName
     */
    protected string $moduleName = 'CrmAutoCar';

    /**
     * @var string $moduleNameLower
     */
    protected string $moduleNameLower = 'crmautocar';

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->mapWebRoutes();
        Blade::componentNamespace('Modules\CrmAutoCar\View\Components', $this->moduleNameLower);
        $this->registerViews();
        $this->loadMigrationsFrom(module_path($this->moduleName,'Database/Migrations'));

        app(CompositeurThemeContract::class)->setViews(DossierAfterSidebarContract::class, [
            new TypeView(TypeView::TYPE_LIVEWIRE, 'crmautocar::block-fournisseur')
        ]);
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom($sourcePath, $this->moduleNameLower);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->group(module_path($this->moduleName, '/Routes/web.php'));
    }
}
