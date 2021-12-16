<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CrmAutoCar\Actions\CreateInvoice;
use Modules\CrmAutoCar\Contracts\Repositories\DevisAutocarRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\PaymentRepositoryContract;
use Modules\CrmAutoCar\Flow\Attributes\CreatePaiementClient;

class PaiementWebhookController
{
    const ERREUR = [
        "0" => "La demande est incomplète, un des champs envoyé pose problème",
        "2" => "Autorisation refusée par l'établissement bancaire. Le client peut essayer à nouveau",
        "3" => "La transaction est refusée, fraude possible",
        "4" => "Transaction refusée en raison d'un problème technique",
        "5" => "Le paiement est autorisé, le n° d'autorisation est dans authorisation_id",
        "51" => "Demande d'autorisation est en attente (Normalement précédé d'une mise à jour 5)",
        "7" => "Paiement annulé",
        "71" => "Annulation du paiement en attente (Normalement précédé d'une mise à jour 7)",
        "8" => "Remboursement effectué",
        "81" => "Remboursement en attente (Normalement précédé d'une mise à jour 8)",
        "9" => "Le paiement est exécuté, le n° d'autorisation est dans authorisation_id",
        "91" => "Le paiement est incertain. Une mise à jour peut intervenir ultérieurement",
        "93" => "Le paiement est refusé (contacter l'aquéreur)",
    ];


    public function listen(Request $request)
    {
        //on écoute le paiement
        if($request->get('notice') === 'PAYMENT') {
            $status = $request->get('stauts');
            if($status == 5){
                $devi = app(DevisAutocarRepositoryContract::class)->fetchById($request->get('order_id'));
                $proformat = $devi->proformat;
                $invoice = $devi->invoice;
                if(!$invoice){
                    $invoice = (new CreateInvoice())->create($devi);
                }

                $payment = app(PaymentRepositoryContract::class)->create($invoice, $request->get('amount'), $request->toArray());
                app(FlowContract::class)->add($devi->dossier, (new CreatePaiementClient($payment)));
            }
        }

        return response('catched', 200);
    }
}
