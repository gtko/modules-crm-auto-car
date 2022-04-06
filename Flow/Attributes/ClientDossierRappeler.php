<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\User;

class ClientDossierRappeler extends Attributes
{
    public Dossier $dossier;
    public UserEntity $commercial;
    public ?UserEntity $user;


    public function __construct(Dossier $dossier, UserEntity $commercial, ?UserEntity $user)
    {
        parent::__construct();

        $this->dossier = $dossier;
        $this->commercial = $commercial;
        $this->user = $user;

    }

    public static function instance(array $value): FlowAttributes
    {
        $dossier = app(DossierRepositoryContract::class)->fetchById($value['dossier_id']);
        $commercial = app(UserRepositoryContract::class)->fetchById($value['commercial_id']);
        $user = app(UserRepositoryContract::class)->fetchById($value['user_id'] ?? 0);

        return (new ClientDossierRappeler($dossier, $commercial, $user));
    }

    public function toArray(): array
    {
        return [
            'dossier_id' => $this->dossier->id,
            'commercial_id' => $this->commercial->id,
            'user_id' => $this->user->id ?? 0,
        ];
    }

    /**
     * @return \Modules\CoreCRM\Models\Dossier
     */
    public function getDossier(): Dossier
    {
        return $this->dossier;
    }

    public function getUser(): ?UserEntity
    {
        return $this->user;
    }

    /**
     * @return \Modules\CoreCRM\Models\Commercial
     */
    public function getCommercial(): UserEntity
    {
        return $this->commercial;
    }
}
