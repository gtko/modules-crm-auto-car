<?php

namespace Modules\CrmAutoCar\Flow\Works\Variables;

use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Flow\Works\Variables\WorkFlowVariable;
use Modules\CoreCRM\Models\User;
use Modules\CrmAutoCar\Entities\InvoicePrice;

class GestionnaireVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'gestionnaire';
    }

    public function data(array $params = []): array
    {
        /** @var \Modules\CrmAutoCar\Models\Dossier $dossier */
        $dossier = $this->event->getData()['dossier'];

        $follower = $dossier->followers()->first();

        if(!$follower){
            $follower = $dossier->commercial;
            if(!$follower){
                $follower = app(UserRepositoryContract::class)->find(1);
            }
        }

        return [
          'email' => $follower->email,
          'phone' => $follower->phone,
          'nom et prénom' => $follower->format_name,
          'signature' => <<<mark
            <div>
                $follower->format_name <br>
                $follower->email <br>
                $follower->phone <br>
            </div>
          mark
        ];
    }

    public function labels(): array
    {
        return [
            'nom et prénom' => 'Nom et prénom du gestionnaire',
            'email' => 'Email du gestionnaire',
            'phone' => 'Numéro de téléphone du gestionnaire',
            'signature' => 'Signature du gestionnaire',
        ];
    }
}
