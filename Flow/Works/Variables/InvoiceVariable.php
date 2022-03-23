<?php

namespace Modules\CrmAutoCar\Flow\Works\Variables;

use Modules\CoreCRM\Flow\Works\Variables\WorkFlowVariable;
use Modules\CrmAutoCar\Entities\InvoicePrice;

class InvoiceVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'facture';
    }

    public function data(array $params = []): array
    {
        /** @var \Modules\CrmAutoCar\Models\Invoice $invoice */
        $invoice = $this->event->getData()['invoice'];

        $price = $invoice->getPrice();
       return [
         'numero' => $invoice->number,
         'lien-pdf' => route('invoice.pdf', $invoice),
         'lien-public' => route('invoices.show', $invoice),
         'total' => $price->getPriceTTC(),
         'tva' => $price->getTauxTVA(),
         'ht' => $price->getPriceHT(),
         'tva-total' => $price->getPriceTVA(),
       ];
    }

    public function labels(): array
    {
        return [
            'numero' => 'Numéro de la facture',
            'lien-pdf' => 'Lien vers le fichier pdf',
            'lien-public' => 'Lien vers la version web du pdf',
            'total' => 'Prix TTC total',
            'tva' => 'Taux de TVA',
            'ht' => 'Prix HT total',
            'tva-total' => 'Montant de la TVA total',
        ];
    }
}
