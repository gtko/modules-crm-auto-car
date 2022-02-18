<?php


namespace Modules\CrmAutoCar\Flow\Attributes;


use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;

class ClientDevisExterneConsultation extends ClientDevisExterneValidation
{
    public static function instance(array $value): FlowAttributes
    {
        $devis = app(DevisRepositoryContract::class)->fetchById($value['devis_id']);
        $data = $devis->data;
        return new ClientDevisExterneConsultation($devis, $value['ip'], $data);
    }
}
