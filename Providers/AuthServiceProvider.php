<?php

namespace Modules\CrmAutoCar\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Models\Personne;
use Modules\BaseCore\Policies\PersonnePolicy;
use Modules\BaseCore\Policies\UserPolicy;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Policies\DeviPolicy;
use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Payment;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\CrmAutoCar\Policies\BrandPolicy;
use Modules\CrmAutoCar\Policies\InvoicePolicy;
use Modules\CrmAutoCar\Policies\PaymentPolicy;
use Modules\CrmAutoCar\Policies\ProformatPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Invoice::class => InvoicePolicy::class,
        Brand::class => BrandPolicy::class,
        Payment::class => PaymentPolicy::class,
        Proformat::class => ProformatPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
