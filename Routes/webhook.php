<?php

use Illuminate\Support\Facades\Route;
use Modules\CrmAutoCar\Http\Controllers\PaiementWebhookController;

Route::any('/webhook/paiement', [PaiementWebhookController::class, 'listen'])->name('webhook-paiement');
