<?php

namespace Modules\CrmAutoCar\Http\Controllers;

class PaiementWebhookController
{
    public function listen()
    {

        //on écoute le paiement

        //on trouve la facture proformat et on créer la facture final

        //Si payé on mets le paiement en succès

        //si échoué on mets le paiement en echec avec un message correspondant


        return response('catched', 200);
    }
}
