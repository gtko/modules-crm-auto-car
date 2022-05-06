<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Status;
use Modules\CrmAutoCar\Contracts\Repositories\DemandeFournisseurRepositoryContract;
use Modules\CrmAutoCar\Models\DemandeFournisseur;
use Modules\CrmAutoCar\Models\Traits\EnumStatusCancel;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;

class DemandeFournisseurRepository extends AbstractRepository implements DemandeFournisseurRepositoryContract
{

    public function getModel(): Model
    {
        return (new DemandeFournisseur());
    }

    public function create(DevisEntities $devis, $fournisseur, $data = []): DemandeFournisseur
    {
        $data['devi_id'] = $devis->id;
        $data['user_id'] = $fournisseur->id;

        return $this->getModel()->create($data);
    }

    public function update(DemandeFournisseur $demandeFournisseur, $data = []): DemandeFournisseur
    {
        $demandeFournisseur->update($data);

        return $demandeFournisseur;
    }

    public function cancel(DemandeFournisseur $demandeFournisseur, $devis = null): DemandeFournisseur
    {
        if(!$devis){
            $devis = $demandeFournisseur->devis;
        }

        $newDemandeCancel =  $this->create($devis, $demandeFournisseur->fournisseur,
            [
                'status' => EnumStatusCancel::STATUS_CANCELLER,
                'prix' => 0 - (float) $demandeFournisseur->prix,
            ]);

        $demandeFournisseur->status = EnumStatusCancel::STATUS_CANCELED;
        $demandeFournisseur->canceled()->associate($newDemandeCancel);
        $demandeFournisseur->save();


        return $newDemandeCancel;
    }

    public function delete(DemandeFournisseur $demandeFournisseur): bool
    {
        return $demandeFournisseur->delete();
    }

    public function getDemandeByDevis(DevisEntities $devis): Collection
    {
        return $this->newQuery()->where('devi_id', $devis->id)->get();
    }

    public function getDemandeByFournisseur($fournisseur): Collection
    {
        return $this->newQuery()->where('fournisseur_id',$fournisseur->id)->get();
    }

    public function getDemandeByDevisAndFournisseur(DevisEntities $devis, $fournisseur): Collection
    {
        return $this->newQuery()->where('devi_id', $devis->id)
            ->where('fournisseur_id', $fournisseur->id)->get();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query;
    }

    public function getDemandeByDossier(Model $dossier): Collection
    {
        return $this->newQuery()->whereHas('devis', function (Builder $query) use ($dossier) {
            $query->where('dossier_id', $dossier->id);
        })->get();
    }
}
