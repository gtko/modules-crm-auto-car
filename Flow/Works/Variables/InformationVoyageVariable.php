<?php

namespace Modules\CrmAutoCar\Flow\Works\Variables;

use Modules\BaseCore\Actions\Url\SigneRoute;
use Modules\CoreCRM\Flow\Works\Variables\WorkFlowVariable;

class InformationVoyageVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'information-voyage';
    }

    public function data(array $params = []): array
    {
        /** @var \Modules\DevisAutoCar\Models\Devi $devis */
        $devis = $this->event->getData()['devis'];

       return [
         'lien-formulaire' =>  (new SigneRoute())->signer('validation-voyage', $devis),
       ];
    }

    public function labels(): array
    {
        return [
            'lien-formulaire' => 'Lien vers le formulaire de validation des informations voyage',
        ];
    }
}
