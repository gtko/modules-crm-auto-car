<?php

namespace Modules\CrmAutoCar\Flow\Works\Variables;

use Modules\CrmAutoCar\Services\Paytweak\Paytweak;

class PaiementVariable extends \Modules\CoreCRM\Flow\Works\Variables\WorkFlowVariable
{

    public function namespace(): string
    {
        return 'paiement';
    }



    public function data(): array
    {
        $datas = $this->event->getData();
        $devis = $datas['devis'];
        $paytweak = app(Paytweak::class);
        $paytweak->connect();
        $result = $paytweak->createLink($devis->id, $devis->getTotal(), $devis->dossier->client);
        $paytweak->disconnect();

        return [
          'lien' => '',
        ];
    }

    public function labels(): array
    {
        return [
            'lien' => 'Lien de paiement'
        ];
    }
}
