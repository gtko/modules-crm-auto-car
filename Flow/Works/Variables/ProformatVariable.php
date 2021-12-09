<?php

namespace Modules\CrmAutoCar\Flow\Works\Variables;

use Modules\CoreCRM\Flow\Works\Variables\WorkFlowVariable;

class ProformatVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'proformat';
    }

    public function data(): array
    {
        /** @var \Modules\CrmAutoCar\Models\Proformat $proformat */
        $proformat = $this->event->getData()['proformat'];

       return [
         'numero' => $proformat->number,
         'lien-pdf' => route('proformats.pdf', $proformat),
         'lien-public' => route('proformats.show', $proformat),
       ];
    }

    public function labels(): array
    {
        return [
            'numero' => 'Numéro de la facture proformat',
            'lien-pdf' => 'Lien vers le fichier pdf',
            'lien-public' => 'Lien vers la version web du pdf'
        ];
    }
}
