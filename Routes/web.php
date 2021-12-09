<?php



use Illuminate\Support\Facades\Route;
use Modules\CrmAutoCar\Http\Controllers\BrandController;
use Modules\CrmAutoCar\Http\Controllers\CentralAutoCarDevisController;
use Modules\CrmAutoCar\Http\Controllers\CuveController;
use Modules\CrmAutoCar\Http\Controllers\InvoicesController;

use Modules\CrmAutoCar\Http\Controllers\MonAutoCarController;
use Modules\CrmAutoCar\Http\Controllers\PlateauListUserByStatusController;
use Modules\CrmAutoCar\Http\Controllers\ProformatsController;
use Modules\CrmAutoCar\Http\Controllers\StatistiqueController;
use Modules\CrmAutoCar\Http\Controllers\StatistiqueFournisseurController;
use Modules\CrmAutoCar\Http\Controllers\TagController;
use Modules\CrmAutoCar\Http\Controllers\TemplateController;
use Modules\CrmAutoCar\Http\Controllers\VuePlateauController;
use Modules\CrmAutoCar\View\Components\Cgv;
use Modules\CrmAutoCar\View\Components\DevisClient\Index;


Route::middleware(['secure.devis'])->group(function () {
    Route::get('/devis/{devis}/{token}',[Index::class, 'index'])->name('devis-view');
    Route::get('/devis/pdf/{devis}/{token}',[Index::class, 'index'])->name('devis-pdf');

});

Route::get('/brand1/devis/{devis}', [CentralAutoCarDevisController::class, 'index'])->name('brand1');
Route::get('/brand2/devis/{devis}', [MonAutoCarController::class, 'index'])->name('brand2');
//Route::get('/mon-autocar/devis/{devis}', [MonAutoCarDevisController::class, 'index'])->name('mon-auto-car-devis');

Route::get('proformats/{proformat}', [ProformatsController::class, 'show'])->name('proformats.show');
Route::get('proformats/{proformat}/pdf', [ProformatsController::class, 'pdf'])->name('proformats.pdf');


Route::prefix('/')
    ->middleware(['auth:web', 'verified'])
    ->group(function () {
        Route::resource('cuves', CuveController::class)->only('index', 'destroy', 'show');
        Route::resource('invoices', InvoicesController::class)->only('index', 'show');
        Route::resource('proformats', ProformatsController::class)->only('index');
        Route::resource('templates', TemplateController::class)->except('show');
        Route::get('statistiques', [StatistiqueController::class, 'index'])->name('statistiques');
        Route::get('statistiques-fournisseur', [StatistiqueFournisseurController::class, 'index'])->name('statistiques-fournisseur');
        Route::resource('brands', BrandController::class);
        Route::resource('tags', TagController::class);
//        Route::resource('templates', TemplatesController::class)->except('show');
        Route::get('vue-plateau', [VuePlateauController::class, 'index'])->name('vue-plateau');
        Route::get('vue-plateau/{commercial_id}/{status_id}', [PlateauListUserByStatusController::class, 'index']);
    });


Route::get('/cgv', [Cgv::class, 'render'])->name('cgv');

Route::get('/mail', function ()
{
//    Mail::to(['d@gmail.com', 'test@test.com'])->send(new RoadmapMail());
});
