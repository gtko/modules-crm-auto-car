<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Dossier;

class ClientDossierRappelWhatsapp extends Attributes
{


    public Dossier $dossier;
    public UserEntity $commercial;

    public function __construct(Dossier $dossier, UserEntity $commercial)
    {
        parent::__construct();
        $this->dossier = $dossier;
        $this->commercial = $commercial;
    }

    public static function instance(array $value): FlowAttributes
    {
        $dossier = app(DossierRepositoryContract::class)->fetchById($value['dossier_id']);
        $commercial = app(UserRepositoryContract::class)->fetchById($value['commercial_id']);

        return (new ClientDossierRappelWhatsapp($dossier, $commercial));
    }

    public function toArray(): array
    {
        return [
            'dossier_id' => $this->dossier->id,
            'commercial_id' => $this->commercial->id,
        ];
    }

    /**
     * @return \Modules\CoreCRM\Models\Dossier
     */
    public function getDossier(): Dossier
    {
        return $this->dossier;
    }

    /**
     * @return \Modules\CoreCRM\Models\Commercial
     */
    public function getCommercial(): UserEntity
    {
        return $this->commercial;
    }

}
