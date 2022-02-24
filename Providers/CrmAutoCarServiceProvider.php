<?php

namespace Modules\CrmAutoCar\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Modules\BaseCore\Contracts\Services\CompositeurThemeContract;
use Modules\BaseCore\Entities\TypeView;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CoreCRM\Contracts\Views\Dossiers\DossierAfterBlockFournisseur;
use Modules\CoreCRM\Contracts\Views\Dossiers\DossierAfterSidebarContract;
use Modules\CoreCRM\Contracts\Views\Dossiers\DossierSidebarAddActionsViewContract;
use Modules\CoreCRM\Contracts\Views\Dossiers\DossierTabLabelViewContract;
use Modules\CoreCRM\Contracts\Views\Dossiers\DossierTabViewContract;
use Modules\CoreCRM\Contracts\Views\Dossiers\SelectCommercial;
use Modules\CoreCRM\Contracts\Views\Dossiers\SelectTagDossier;
use Modules\CoreCRM\Flow\Attributes\ClientDossierCreate;
use Modules\CoreCRM\Flow\Works\Services\TemplateMailService;
use Modules\CoreCRM\Flow\Works\WorkflowKernel;
use Modules\CoreCRM\Notifications\Kernel;
use Modules\CoreCRM\Repositories\PipelineRepository;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ConfigsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ContactFournisseurRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\DevisAutocarRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\PaymentRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\PlateauRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ShekelRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\StatistiqueReservationRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\TemplatesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Service\DistanceApiContract;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;
use Modules\CrmAutoCar\Flow\Works\Events\EventAddTagDossier;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDevisClientModifValidation;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDevisClientSaveValidation;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDevisExterneConsultation;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDevisExterneValidation;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierAttribuer;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierFournisseurBpa;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierPaiementFournisseurSend;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierRappeler;
use Modules\CrmAutoCar\Flow\Works\Events\EventCreatePaiementClient;
use Modules\CrmAutoCar\Flow\Works\Events\EventCreateProformatClient;
use Modules\CrmAutoCar\Flow\Works\Events\EventDevisSendClient;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierDemandeFournisseurDelete;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierDemandeFournisseurSend;
use Modules\CrmAutoCar\Flow\Works\Events\EventClientDossierDemandeFournisseurValidate;
use Modules\CrmAutoCar\Flow\Works\Events\EventEditMargeProformat;
use Modules\CrmAutoCar\Flow\Works\Events\EventSendEmailDossier;
use Modules\CrmAutoCar\Flow\Works\Events\EventSendInformationVoyageMailFournisseur;
use Modules\CrmAutoCar\Flow\Works\Events\EventSendInvoice;
use Modules\CrmAutoCar\Flow\Works\Events\EventSendProformat;
use Modules\CrmAutoCar\Notifications\ClientDevisExterneValidationNotification;
use Modules\CrmAutoCar\Notifications\ClientDossierDemandeFournisseurSendNotification;
use Modules\CrmAutoCar\Notifications\DevisSendClientNotification;
use Modules\CrmAutoCar\Notifications\DossierAttribuerNotification;
use Modules\CrmAutoCar\Repositories\BrandsRepository;
use Modules\CrmAutoCar\Repositories\ConfigRepository;
use Modules\CrmAutoCar\Repositories\ContactFournisseurRepository;
use Modules\CrmAutoCar\Repositories\DecaissementRepository;
use Modules\CrmAutoCar\Repositories\DevisAutocarRepository;
use Modules\CrmAutoCar\Repositories\DossierAutoCarRepository;
use Modules\CrmAutoCar\Repositories\InvoicesRepository;
use Modules\CrmAutoCar\Repositories\PaymentRepository;
use Modules\CrmAutoCar\Repositories\PlateauRepository;
use Modules\CrmAutoCar\Repositories\ProformatsRepository;
use Modules\CrmAutoCar\Repositories\ShekelRepositories;
use Modules\CrmAutoCar\Repositories\StatistiqueRepository;
use Modules\CrmAutoCar\Repositories\StatistiqueReservationRepository;
use Modules\CrmAutoCar\Repositories\TagsRepository;
use Modules\CrmAutoCar\Repositories\TemplateRepository;
use Modules\CrmAutoCar\Services\Google\DistanceMatrixApi;
use Modules\CrmAutoCar\Services\Paytweak\Paytweak;
use Modules\CrmAutoCar\Services\FlowAutocarCRM;

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
        $this->register(AuthServiceProvider::class);


        $this->app->bind(InvoicesRepositoryContract::class, InvoicesRepository::class);
        $this->app->bind(ProformatsRepositoryContract::class, ProformatsRepository::class);
        $this->app->bind(DistanceApiContract::class, DistanceMatrixApi::class);
        $this->app->bind(TemplatesRepositoryContract::class, TemplateRepository::class);
        $this->app->bind(BrandsRepositoryContract::class, BrandsRepository::class);
        $this->app->bind(StatistiqueRepositoryContract::class, StatistiqueRepository::class);
        $this->app->bind(DecaissementRepositoryContract::class, DecaissementRepository::class);
        $this->app->bind(TagsRepositoryContract::class, TagsRepository::class);
        $this->app->bind(PlateauRepositoryContract::class, PlateauRepository::class);
        $this->app->bind(ConfigsRepositoryContract::class, ConfigRepository::class);
        $this->app->bind(ContactFournisseurRepositoryContract::class, ContactFournisseurRepository::class);
        $this->app->bind(StatistiqueReservationRepositoryContract::class, StatistiqueReservationRepository::class);

        $this->app->bind(DevisRepositoryContract::class, DevisAutocarRepository::class);
        $this->app->bind(DevisAutocarRepositoryContract::class, DevisAutocarRepository::class);

        $this->app->bind(PaymentRepositoryContract::class, PaymentRepository::class);
        $this->app->bind(DossierRepositoryContract::class, DossierAutoCarRepository::class);
        $this->app->bind(ShekelRepositoryContract::class,ShekelRepositories::class);

        $this->app->bind(FlowContract::class,FlowAutocarCRM::class);

        $this->app->bind(ClientDossierCreate::class, \Modules\CrmAutoCar\Flow\Attributes\ClientDossierCreate::class);
//        $this->app->bind(\Modules\CrmAutoCar\Flow\Attributes\SendEmailDossier::class, \Modules\CrmAutoCar\Flow\Attributes\SendEmailDossier::class);
//        $this->app->bind(EventSendEmailDossier::class, EventSendEmailDossier::class);


        $this->app->bind(Paytweak::class, function(){
            return (new Paytweak(env('PAYTWEAK_PUBLIC', ''), env('PAYTWEAK_PRIVATE', '')));
        });

        $this->mapWebRoutes();
        Blade::componentNamespace('Modules\CrmAutoCar\View\Components', $this->moduleNameLower);
        $this->registerViews();
        $this->registerConfig();
        $this->loadMigrationsFrom(module_path($this->moduleName,'Database/Migrations'));

        app(CompositeurThemeContract::class)->setViews(DossierAfterSidebarContract::class, [
            new TypeView(TypeView::TYPE_LIVEWIRE, 'crmautocar::block-fournisseur'),
            new TypeView(TypeView::TYPE_LIVEWIRE, 'crmautocar::block-paiment-fournisseur'),
            new TypeView(TypeView::TYPE_LIVEWIRE, 'crmautocar::contact-chauffeur-fournisseur'),
        ]);
        app(CompositeurThemeContract::class)->setViews(SelectTagDossier::class, [
            new TypeView(TypeView::TYPE_LIVEWIRE, 'crmautocar::select-tags'),
        ]);
        app(CompositeurThemeContract::class)->setViews(SelectCommercial::class, [
           new TypeView(typeView:: TYPE_LIVEWIRE, 'crmautocar::select-commercial'),
        ]);

        app(CompositeurThemeContract::class)->setViews(DossierSidebarAddActionsViewContract::class,
            [
                new TypeView(TypeView::TYPE_LIVEWIRE, 'crmautocar::arappeler')
            ]
        )
            ->setViews(DossierTabLabelViewContract::class, [
                new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'crmautocar::proformat-label-tab'),
                new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'crmautocar::invoice-label-tab'),
                new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'crmautocar::payment-label-tab'),
                new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'crmautocar::validation-label-tab'),
                new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'crmautocar::email-label-tab')
            ])
            ->setViews(DossierTabViewContract::class, [
                new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'crmautocar::proformat-view-tab'),
                new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'crmautocar::invoice-view-tab'),
                new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'crmautocar::payment-view-tab'),
                new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'crmautocar::validation-view-tab'),
                new TypeView(TypeView::TYPE_BLADE_COMPONENT, 'crmautocar::email-view-tab')
            ]);

        $this->registerNotif();
        $this->registerWorkFlowEvents();
    }

    public function registerWorkFlowEvents(){

        app(WorkflowKernel::class)->addEvents([
            EventDevisSendClient::class,
            EventClientDevisExterneConsultation::class,
            EventClientDevisExterneValidation::class,
            EventClientDossierDemandeFournisseurDelete::class,
            EventClientDossierDemandeFournisseurSend::class,
            EventClientDossierDemandeFournisseurValidate::class,
            EventClientDossierPaiementFournisseurSend::class,
            EventCreateProformatClient::class,
            EventClientDossierAttribuer::class,
            EventClientDossierRappeler::class,
            EventCreatePaiementClient::class,
            EventClientDossierFournisseurBpa::class,
            EventClientDevisClientSaveValidation::class,
            EventClientDevisClientModifValidation::class,
            EventEditMargeProformat::class,
            EventSendInformationVoyageMailFournisseur::class,
            EventAddTagDossier::class,
            EventSendProformat::class,
            EventSendInvoice::class
        ]);

        app(TemplateMailService::class)
            ->add('MonAutoCar', 'crmautocar::emails.monautocar', TemplateMailService::TYPE_HTML)
            ->add('LocationDeCar', 'crmautocar::emails.location-de-car', TemplateMailService::TYPE_HTML);
    }


    public function registerNotif()
    {
        Kernel::add([
            DossierAttribuerNotification::class
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
     * Register config
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
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

        Route::middleware('api')
            ->group(module_path($this->moduleName, '/Routes/webhook.php'));
    }
}
