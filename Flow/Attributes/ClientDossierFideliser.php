<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\User;

class ClientDossierFideliser extends Attributes
{
    public Dossier $dossier;

    public function __construct(Dossier $dossier)
    {
        parent::__construct();

        $this->dossier = $dossier;
    }

    public static function instance(array $value): FlowAttributes
    {
        $dossier = app(DossierRepositoryContract::class)->fetchById($value['dossier_id']);

        return (new ClientDossierFideliser($dossier));
    }

    public function toArray(): array
    {
        return [
            'dossier_id' => $this->dossier->id,
        ];
    }

    /**
     * @return \Modules\CoreCRM\Models\Dossier
     */
    public function getDossier(): Dossier
    {
        return $this->dossier;
    }
}
