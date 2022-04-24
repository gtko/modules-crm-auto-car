<?php


namespace Modules\CrmAutoCar\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;

class ClientDossierDevisSendWhatsapp extends Attributes
{

    protected UserEntity $user;
    protected ?DevisEntities $devis;


    public function getType(): string
    {
        return static::TYPE_EMAIL;
    }

    public function __construct(UserEntity $user, ?DevisEntities $devis)
    {
        parent::__construct();
        $this->user = $user;
        $this->devis = $devis;

    }

    public static function instance(array $value): FlowAttributes
    {
        $repDevis = app(DevisRepositoryContract::class);

        $user = app(UserEntity::class)::find($value['user_id'] ?? null);
        $devis = $repDevis->fetchById($value['devis_id'] ?? null);


        return new ClientDossierDevisSendWhatsapp($user, $devis);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id,
            'devis_id' => $this->devis->id ?? null,
        ];
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }

    /**
     * @return DevisEntities
     */
    public function getDevis(): ?DevisEntities
    {
        return $this->devis ?? null;
    }


}
