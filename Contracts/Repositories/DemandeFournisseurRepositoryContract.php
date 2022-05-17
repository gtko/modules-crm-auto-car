<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Models\DemandeFournisseur;
use Modules\CrmAutoCar\Models\Fournisseur;


interface DemandeFournisseurRepositoryContract extends RepositoryFetchable
{

    public function create(DevisEntities $devis, $fournisseur, $data = []): DemandeFournisseur;
    public function update(DemandeFournisseur $demandeFournisseur, $data = []): DemandeFournisseur;
    public function cancel(DemandeFournisseur $demandeFournisseur, $devis = null): DemandeFournisseur;
    public function delete(DemandeFournisseur $demandeFournisseur): bool;

    public function getDemandeByDossier(Model $dossier): Collection;
    public function getDemandeByDevis(DevisEntities $devis): Collection;
    public function getDemandeByFournisseur($fournisseur): Collection;
    public function getDemandeByDevisAndFournisseur(DevisEntities $devis, $fournisseur): Collection;

}
