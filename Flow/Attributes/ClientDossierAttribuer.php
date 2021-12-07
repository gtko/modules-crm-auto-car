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

class ClientDossierAttribuer extends Attributes
{
    public Dossier $dossier;
    public Commercial $commercial;
    public User $attributeur;

    public function __construct(Dossier $dossier, Commercial $commercial, User $attributeur)
    {
        parent::__construct();

        $this->dossier = $dossier;
        $this->commercial = $commercial;
        $this->attributeur = $attributeur;
    }

    public static function instance(array $value): FlowAttributes
    {

        $dossier = app(DossierRepositoryContract::class)->fetchById($value['dossier_id']);
        $commercial = app(CommercialRepositoryContract::class)->fetchById($value['commercial_id']);
        $attributeur = app(UserRepositoryContract::class)->fetchById($value['attributeur_id']);

        return (new ClientDossierAttribuer($dossier, $commercial, $attributeur));
    }

    public function toArray(): array
    {
        return [
            'dossier_id' => $this->dossier->id,
            'commercial_id' => $this->commercial->id,
            'attributeur_id' => $this->attributeur->id,
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
    public function getCommercial(): Commercial
    {
        return $this->commercial;
    }

    /**
     * @return \Modules\CoreCRM\Models\User
     */
    public function getAttributeur(): User
    {
        return $this->attributeur;
    }


}
