<?php

namespace Modules\CrmAutoCar\Flow\Works\Variables;

use Modules\CoreCRM\Flow\Works\Variables\WorkFlowVariable;

class ClientValidationVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'clientvalidation';
    }

    public function data(array $params = []): array
    {
        /** @var \Modules\CrmAutoCar\Models\Proformat $proformat */
        $devis = $this->event->getData()['devis'];

       return [
           "paiement type" => $devis->data['paiement_type_validation'] ?? '',
           "name" => $devis->data['name_validation'] ?? '',
           "societe" => $devis->data['societe_validation'] ?? '',
           "adresse" => $devis->data['address_validation'] ?? '',
           "ip" => $devis->data['ip_validation'] ?? '',
       ];
    }

    public function labels(): array
    {
        return [
            "paiement type" => 'paiement choisit par validation',
            "name" => 'nom de validation',
            "societe" => 'société de la validation',
            "adresse" => 'adresse validation',
            "ip" => 'ip de la validation'
        ];
    }
}
