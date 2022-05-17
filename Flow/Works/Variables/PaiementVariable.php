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
        /** @var \Modules\CrmAutoCar\Entities\ProformatPrice $priceProformat */
        $priceProformat =  $datas['proformat']->price;

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
            $price = $priceProformat->remains() - ($priceProformat->remains() / (($params[1]/100) + 1));
        }else{
            $price = $priceProformat->remains();
        }

        if(!$active) {
            $active = $paytweak->createLink($devis->id, $price, $devis->dossier->client);
        }

        $paytweak->disconnect();

        $payment = $datas['payment'] ?? null;

        return [
          'lien' => $active['url'] ?? '',
          'total-lien' => $price,
          'total-ttc' => $priceProformat->getPriceTTC(),
          'total-ht' => $priceProformat->getPriceHT(),
          'tva' => $priceProformat->getPriceTVA(),
          'taux-tva' => $priceProformat->getTauxTVA(),
          'reste' =>  $priceProformat->remains(),
          'payé' => $priceProformat->paid(),
          'somme-payé' => $payment->total ?? 0
        ];
    }

    public function labels(): array
    {
        return [
            'lien' => 'Lien de paiement',
            'total-lien' => 'Total demandé sur le lien de paiement',
            'total-ttc' => 'Total de la facture en TTC',
            'total-ht' => 'Total de la facture en HT',
            'tva' => 'Total de la TVA',
            'taux-tva' => 'Taux de TVA',
            'reste' =>  'Reste à payer',
            'payé' => 'Déjà Payé',
            'somme-payé' => 'Somme payé sur ce paiement'
        ];
    }
}
