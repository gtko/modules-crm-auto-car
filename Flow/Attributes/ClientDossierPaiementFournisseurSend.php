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

class ClientDossierPaiementFournisseurSend extends Attributes
{

    protected UserEntity $user;
    protected ?DevisEntities $devis;
    protected Fournisseur $fournisseur;
    protected ?Decaissement $decaissement;

    public function __construct(UserEntity $user, ?DevisEntities $devis, Fournisseur $fournisseur, ?Decaissement $decaissement)
    {
        parent::__construct();
        $this->user = $user;
        $this->devis = $devis;
        $this->fournisseur = $fournisseur;
        $this->decaissement = $decaissement;
    }

    public static function instance(array $value): FlowAttributes
    {
        $repFournisseur =  app(FournisseurRepositoryContract::class);
        $repDevis = app(DevisRepositoryContract::class);

        $repFournisseur->disabled();

        $user = app(UserEntity::class)::find($value['user_id']);
        $fournisseur = $repFournisseur->fetchById($value['fournisseur_id']);
        $devis = $repDevis ->fetchById($value['devis_id']);
        $decaissement = app(DecaissementRepositoryContract::class)->fetchById($value['decaissement_id']);


        return new ClientDossierPaiementFournisseurSend($user, $devis, $fournisseur, $decaissement);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id,
            'devis_id' => $this->devis->id ?? 0,
            'fournisseur_id' => $this->fournisseur->id,
            'decaissement_id' => $this->decaissement->id ?? 0,
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
        return $this->devis;
    }

    /**
     * @return Fournisseur
     */
    public function getFournisseur(): Fournisseur
    {
        return $this->fournisseur;
    }

    /**
     * @return Decaissement
     */
    public function getDecaissement(): ?Decaissement
    {
        return $this->decaissement;
    }


}
