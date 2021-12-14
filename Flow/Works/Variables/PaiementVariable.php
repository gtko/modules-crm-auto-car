<?php

namespace Modules\CrmAutoCar\Flow\Works\Variables;

use Modules\CrmAutoCar\Services\Paytweak\Paytweak;

class PaiementVariable extends \Modules\CoreCRM\Flow\Works\Variables\WorkFlowVariable
{

    public function namespace(): string
    {
        return 'paiement';
    }

    public function data(array $params = []): array
    {
        $datas = $this->event->getData();
        $devis = $datas['devis'];

        $paytweak = app(Paytweak::class);
        $paytweak->connect();
        $links = $paytweak->getLink($devis->id);
        $active = false;
        if($links){
            foreach($links as $link){
                if(($link['active'] ?? '0') == 1){
                    $active = $link;
                    $active['url'] = $active['link_url'];
                }
            }
        }

        if(($params[1] ?? false)){
            $price = $devis->getTotal() - ($devis->getTotal() / (($params[1]/100) + 1));
        }else{
            $price = $devis->getTotal();
        }

        if(!$active) {
            $active = $paytweak->createLink($devis->id, $price, $devis->dossier->client);
        }

        $paytweak->disconnect();

        return [
          'lien' => $active['url'],
        ];
    }

    public function labels(): array
    {
        return [
            'lien' => 'Lien de paiement'
        ];
    }
}
