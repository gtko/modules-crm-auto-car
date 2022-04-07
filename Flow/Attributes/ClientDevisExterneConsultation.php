<?php


namespace Modules\CrmAutoCar\Flow\Attributes;


use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\DevisAutoCar\Models\Devi;

class ClientDevisExterneConsultation extends ClientDevisExterneValidation
{
    public static function instance(array $value): FlowAttributes
    {
        $rep = app(DevisRepositoryContract::class);
        $devis = $rep->fetchById($value['devis_id']);
        $data = $devis->data ?? [];
        return new ClientDevisExterneConsultation($devis ?? (new Devi()), $value['ip'], $data);
    }
}
