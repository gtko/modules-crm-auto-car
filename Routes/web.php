<?php

use Illuminate\Support\Facades\Route;
use Modules\CrmAutoCar\View\Components\DevisClient\Index;

Route::middleware(['secure.devis'])->group(function () {
    Route::get('/devis/{devis}/{token}', [Index::class, 'index'])->name('devis-view');
});
