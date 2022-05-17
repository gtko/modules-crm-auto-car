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
            $format_name = 'Emilie Garcin';
            $email = 'contact@centrale-autocar.com';
            $phone = '01 87 21 14 76';
        }else{
            $format_name = $follower->format_name ?? 'Emilie Garcin';
            $email = $follower->email ?? 'contact@centrale-autocar.com';
            $phone = $follower->phone ?? '01 87 21 14 76';
        }




        return [
          'email' => $follower->email ?? 'contact@centrale-autocar.com',
          'phone' => $follower->phone ?? '01 87 21 14 76',
          'avatar' => $follower->avatar_url ?? '',
          'nom et prénom' => $follower->format_name ?? 'Emilie Garcin',
          'signature' => <<<mark
            <div>
                $format_name <br>
                $email <br>
                $phone <br>
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
            'avatar' => 'Avatar du gestionnaire',
            'signature' => 'Signature du gestionnaire',
        ];
    }
}
