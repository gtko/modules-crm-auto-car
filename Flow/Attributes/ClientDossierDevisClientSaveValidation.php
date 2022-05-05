<?php


namespace Modules\CrmAutoCar\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;

class ClientDossierDevisClientSaveValidation extends Attributes
{

    protected ?DevisEntities $devis;


    public function __construct(?DevisEntities $devis)
    {
        parent::__construct();
        $this->devis = $devis;
    }

    public static function instance(array $value): FlowAttributes
    {
        $repDevis = app(DevisRepositoryContract::class);
        $devis = $repDevis ->fetchById($value['devis_id']);

        return new ClientDossierDevisClientSaveValidation($devis);
    }

    public function toArray(): array
    {
        return [
            'devis_id' => $this->devis->id ?? 0,
        ];
    }

    /**
     * @return DevisEntities
     */
    public function getDevis(): ?DevisEntities
    {
        return $this->devis;
    }


}
