<?php

namespace Modules\CrmAutoCar\Flow\Works\Variables;

use Modules\CoreCRM\Flow\Works\Variables\WorkFlowVariable;

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

       return [
         'numero' => $invoice->number,
         'lien-pdf' => route('invoice.pdf', $invoice),
         'lien-public' => route('invoices.show', $invoice),
       ];
    }

    public function labels(): array
    {
        return [
            'numero' => 'Numéro de la facture',
            'lien-pdf' => 'Lien vers le fichier pdf',
            'lien-public' => 'Lien vers la version web du pdf'
        ];
    }
}
