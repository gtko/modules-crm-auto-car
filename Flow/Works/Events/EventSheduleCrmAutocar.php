<?php

namespace Modules\CrmAutoCar\Flow\Works\Events;

use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Attributes\SheduleAttribute;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDevis;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionCountDossier;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionStatus;
use Modules\CoreCRM\Flow\Works\Conditions\ConditionTag;
use Modules\CoreCRM\Flow\Works\Events\EventShedule;
use Modules\CoreCRM\Flow\Works\Variables\DossierVariable;
use Modules\CoreCRM\Flow\Works\Variables\UserVariable;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionClientSolde;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionClientTypeValidation;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionConcurentDevis;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionDateDepartDevis;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionFournisseurBPA;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionFournisseurSolde;
use Modules\CrmAutoCar\Flow\Works\Conditions\ConditionPaiementTypeValidation;

class EventSheduleCrmAutocar extends EventShedule
{

    public function listen():array
    {
        return [
            SheduleAttribute::class
        ];
    }

    public function category():string
    {
        return "Shedule";
    }

    public function name():string
    {
        return "Lancement régulier de l'event";
    }

    public function describe():string
    {
        return "Evenement déclencher régulièrement toutes les 5 minutes";
    }


    protected function prepareData(Attributes $flowAttribute): array
    {
        return [
            'dossier' => $flowAttribute->getDossier(),
            'devis' => $flowAttribute->getDevis(),
        ];
    }

    public function variables():array
    {
        return [
            (new UserVariable($this)),
            (new DossierVariable($this)),
        ];
    }


    public function conditions():array
    {
        return [
            ConditionCountDevis::class,
            ConditionStatus::class,
            ConditionCountDossier::class,
            ConditionTag::class,
            ConditionClientSolde::class,
            ConditionClientTypeValidation::class,
            ConditionConcurentDevis::class,
            ConditionDateDepartDevis::class,
            ConditionFournisseurBPA::class,
            ConditionFournisseurSolde::class,
        ];
    }
}
