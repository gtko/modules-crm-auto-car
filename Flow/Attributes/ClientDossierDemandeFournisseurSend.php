<?php


namespace Modules\CrmAutoCar\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Fournisseur;


class ClientDossierDemandeFournisseurSend extends Attributes
{
    protected UserEntity $user;
    protected DevisEntities $devis;
    protected Fournisseur $fournisseur;

    public function __construct(UserEntity $user, DevisEntities $devis, Fournisseur $fournisseur, string $prix)
    {
        parent::__construct();
        $this->user = $user;
        $this->devis = $devis;
        $this->fournisseur = $fournisseur;
        $this->prix = $prix;
    }

    public static function instance(array $value): FlowAttributes
    {
        $repFournisseur =  app(FournisseurRepositoryContract::class);
        $repDevis = app(DevisRepositoryContract::class);

        $user = app(UserEntity::class)::find($value['user_id']);
        $fournisseur = $repFournisseur->fetchById($value['fournisseur_id']);
        $devis = $repDevis ->fetchById($value['devis_id']);
        $prix = app(DevisRepositoryContract::class)->getPrice($devis, $fournisseur);


        return new ClientDossierDemandeFournisseurSend($user, $devis, $fournisseur, $prix);
    }

    public function toArray(): array
    {
       return [
           'user_id' => $this->user->id,
           'devis_id' => $this->devis->id,
           'fournisseur_id' => $this->fournisseur->id,
           'prix' => $this->prix,
       ];
    }

    public function getUser():UserEntity
    {
        return $this->user;
    }

    /**
     * @return DevisEntities
     */
    public function getDevis(): DevisEntities
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
     * @return string
     */
    public function getPrix(): string
    {
        return $this->prix;
    }




}
