<?php



use Illuminate\Support\Facades\Route;
use Modules\CrmAutoCar\Http\Controllers\CuveController;
use Modules\CrmAutoCar\Http\Controllers\InvoicesController;
use Modules\CrmAutoCar\Http\Controllers\TemplateController;
use Modules\CrmAutoCar\View\Components\DevisClient\Index;


Route::middleware(['secure.devis'])->group(function () {
    Route::get('/devis/{devis}/{token}',[Index::class, 'index'])->name('devis-view');
    Route::get('/devis/pdf/{devis}/{token}',[Index::class, 'index'])->name('devis-pdf');
});

Route::prefix('/')
    ->middleware(['auth:web', 'verified'])
    ->group(function () {
        Route::resource('cuves', CuveController::class)->only('index', 'destroy', 'show');
        Route::resource('invoices', InvoicesController::class)->only('index', 'destroy', 'show');
        Route::resource('templates', TemplateController::class)->except('show');
//        Route::resource('brands', BrandController::class);
//        Route::resource('templates', TemplatesController::class)->except('show');
    });


Route::get('/mail', function ()
{
//    Mail::to(['d@gmail.com', 'test@test.com'])->send(new RoadmapMail());
});
