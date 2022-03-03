<?php


use Illuminate\Support\Facades\Route;
use Modules\BaseCore\Actions\Url\SigneRoute;
use Modules\BaseCore\Models\Personne;
use Modules\CoreCRM\Models\Client;
use Modules\CrmAutoCar\Http\Controllers\BrandController;
use Modules\CrmAutoCar\Http\Controllers\CentralAutoCarDevisController;
use Modules\CrmAutoCar\Http\Controllers\CuveController;
use Modules\CrmAutoCar\Http\Controllers\DashboardController;
use Modules\CrmAutoCar\Http\Controllers\DossierController;
use Modules\CrmAutoCar\Http\Controllers\InfomationVogageController;
use Modules\CrmAutoCar\Http\Controllers\InvoicesController;

use Modules\CrmAutoCar\Http\Controllers\MonAutoCarController;
use Modules\CrmAutoCar\Http\Controllers\PlateauListUserByStatusController;
use Modules\CrmAutoCar\Http\Controllers\ProformatsController;
use Modules\CrmAutoCar\Http\Controllers\StatistiqueController;
use Modules\CrmAutoCar\Http\Controllers\StatistiqueFournisseurController;
use Modules\CrmAutoCar\Http\Controllers\TagController;
use Modules\CrmAutoCar\Http\Controllers\TemplateController;
use Modules\CrmAutoCar\Http\Controllers\ValidationInformationVoyageController;
use Modules\CrmAutoCar\Http\Controllers\VuePlateauController;
use Modules\CrmAutoCar\Models\Dossier;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\View\Components\Cgv;
use Modules\CrmAutoCar\View\Components\DevisClient\Index;


Route::get('/testurl', function () {

    $dossier = Dossier::find(6);
    $dossier->status_id = 5;
    $dossier->save();

    return 'OK';
});


Route::middleware(['secure.devis'])->group(function () {
    Route::get('/devis/{devis}/{token}', [Index::class, 'index'])->name('devis-view');
    Route::get('/devis/pdf/{devis}/{token}', [Index::class, 'index'])->name('devis-pdf');
});

Route::middleware(['secure.signate'])->group(function () {
    Route::get('/voyage/{devis}', [ValidationInformationVoyageController::class, 'index'])->name('validation-voyage');


});

Route::get('/brand1/devis/{devis}', [CentralAutoCarDevisController::class, 'index'])->name('brand1');
Route::get('/brand2/devis/{devis}', [MonAutoCarController::class, 'index'])->name('brand2');
Route::get('/information-voyage/{devis}', [InfomationVogageController::class, 'index'])->name('info-voyage');

//Route::get('/mon-autocar/devis/{devis}', [MonAutoCarDevisController::class, 'index'])->name('mon-auto-car-devis');

Route::get('proformats/{proformat}', [ProformatsController::class, 'show'])->name('proformats.show');
Route::get('proformats/{proformat}/pdf', [ProformatsController::class, 'pdf'])->name('proformats.pdf');

Route::get('invoices/{invoice}', [InvoicesController::class, 'show'])->name('invoices.show');
Route::get('invoices/{invoice}/pdf', [InvoicesController::class, 'pdf'])->name('invoices.pdf');



Route::prefix('/')
    ->middleware(['auth:web', 'verified'])
    ->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index']);

        Route::resource('cuves', CuveController::class)->only('index', 'destroy', 'show');
        Route::resource('invoices', InvoicesController::class)->only('index', 'show');
        Route::resource('proformats', ProformatsController::class)->only('index');
        Route::resource('templates', TemplateController::class)->except('show');


        Route::get('dossiers/create/{client}', [\Modules\CrmAutoCar\Http\Controllers\DossierCreateController::class, 'index'])->name('dossier-create');
        Route::get('dossiers/', [DossierController::class, 'index'])->name('dossiers.index');

        Route::get('clients/{client}/dossiers/{dossier}', [DossierController::class, 'show'])->name('dossiers.show');


        Route::get('statistiques', [StatistiqueController::class, 'index'])->name('statistiques');
        Route::get('statistiques-fournisseur', [StatistiqueFournisseurController::class, 'index'])->name('statistiques-fournisseur');
        Route::resource('brands', BrandController::class);
        Route::resource('tags', TagController::class);
//        Route::resource('templates', TemplatesController::class)->except('show');
        Route::get('vue-plateau', [VuePlateauController::class, 'index'])->name('vue-plateau');
        Route::get('vue-plateau/{commercial_id}/{status_id}', [PlateauListUserByStatusController::class, 'index']);
    });

Route::get('/cgv', [Cgv::class, 'render'])->name('cgv');

Route::get('/mail', function () {
//    Mail::to(['d@gmail.com', 'test@test.com'])->send(new RoadmapMail());
});
