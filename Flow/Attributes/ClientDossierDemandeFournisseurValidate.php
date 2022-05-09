<?php


namespace Modules\CrmAutoCar\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Fournisseur;

class ClientDossierDemandeFournisseurValidate extends Attributes
{

    public function __construct(
        UserEntity $user,
        ?DevisEntities $devis,
        Fournisseur $fournisseur,
        float $price
    ){
        parent::__construct();
        $this->user = $user;
        $this->devis = $devis;
        $this->fournisseur = $fournisseur;
        $this->price = $price;
    }

    public static function instance(array $value): FlowAttributes
    {

        $repFournisseur =  app(FournisseurRepositoryContract::class);
        $repDevis = app(DevisRepositoryContract::class);

        $user = app(UserEntity::class)::find($value['user_id']);
        $fournisseur = $repFournisseur->disabled()->fetchById($value['fournisseur_id']);
        $devis = $repDevis->fetchById($value['devis_id']);

        if($devis) {
            $price = $value['price'] ?? 0;
        } else {
            $price = 0;
        }

        return new ClientDossierDemandeFournisseurValidate($user, $devis, $fournisseur, $price);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id,
            'devis_id' => $this->devis->id ?? 0,
            'fournisseur_id' => $this->fournisseur->id,
            'price' => $this->price ?? 0,
        ];
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }
    public function getUser():UserEntity
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


}
