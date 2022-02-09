<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Models\ContactFournisseur;
use Modules\CoreCrm\Models\Fournisseur;

interface ContactFournisseurRepositoryContract
{
    public function create(Dossier $dossier, Fournisseur $fournisseur, DevisEntities $devi, string $name, string $phone, array $data = null, int $trajet_index = null): ContactFournisseur;

    public function update(ContactFournisseur $contactFournisseur, string $name, string $phone, array $data = null): ContactFournisseur;

    public function delete(ContactFournisseur $contactFournisseur): bool;

    public function send(ContactFournisseur $contactFournisseur): ContactFournisseur;

    public function getByDossier(Dossier $dossier): Collection;

    public function getByFournisseur(Fournisseur $fournisseur): Collection;

}
