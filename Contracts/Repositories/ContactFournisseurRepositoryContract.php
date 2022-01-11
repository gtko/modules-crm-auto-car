<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Models\ContactFournisseur;
use Modules\CoreCrm\Models\Fournisseur;

interface ContactFournisseurRepositoryContract
{
    public function create(Dossier $dossier, Fournisseur $fournisseur, string $name, string $phone):ContactFournisseur;
    public function update(ContactFournisseur $contactFournisseur, string $name, string $phone):ContactFournisseur;
    public function delete(ContactFournisseur $contactFournisseur):bool;

    public function getByDossier(Dossier $dossier):Collection;
    public function getByFournisseur(Fournisseur $fournisseur):Collection;

}
