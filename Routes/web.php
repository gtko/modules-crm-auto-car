<?php

use App\Http\Controllers\TemplatesController;
use Illuminate\Support\Facades\Route;
use Modules\CrmAutoCar\Http\Controllers\CuveController;
use Modules\CrmAutoCar\View\Components\DevisClient\Index;


Route::middleware(['secure.devis'])->group(function () {
    Route::get('/devis/{devis}/{token}',[Index::class, 'index'])->name('devis-view');
    Route::get('/devis/pdf/{devis}/{token}',[Index::class, 'index'])->name('devis-pdf');
});

Route::prefix('/')
    ->middleware(['auth:web', 'verified'])
    ->group(function () {

        Route::get('/mail', function () {
            \Illuminate\Support\Facades\Mail::to('aurelienverdeau@gmail.com')->send(new \Modules\CrmAutoCar\Mail\AccepteDevisConseillerMail());
        });

        Route::resource('cuves', CuveController::class)->only('index', 'destroy', 'show');
//        Route::resource('brands', BrandController::class);
//        Route::resource('templates', TemplatesController::class)->except('show');
    });
