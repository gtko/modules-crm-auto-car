<?php

use Illuminate\Support\Facades\Route;
use Modules\CrmAutoCar\Http\Controllers\EndpointController;

Route::any('api/v1/dossiers',[EndpointController::class, 'create'])->name('api.dossier.create');
