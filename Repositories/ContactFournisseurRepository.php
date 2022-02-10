<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Contracts\Repositories\ContactFournisseurRepositoryContract;
use Modules\CrmAutoCar\Models\ContactFournisseur;

class ContactFournisseurRepository extends AbstractRepository implements ContactFournisseurRepositoryContract
{

    public function create(Dossier $dossier, Fournisseur $fournisseur, DevisEntities $devi, string $name, string $phone, array $data = null, int $trajet_index = null): ContactFournisseur
    {
        return ContactFournisseur::create([
            'dossier_id' => $dossier->id,
            'fournisseur_id' => $fournisseur->id,
            'devi_id' => $devi->id,
            'name' => $name,
            'phone' => $phone,
            'data' => $data,
            'trajet_index' => $trajet_index
        ]);


    }

    public function update(ContactFournisseur $contactFournisseur, string $name, string $phone, array $data = null): ContactFournisseur
    {
        $contactFournisseur->update([
            'name' => $name,
            'phone' => $phone,
            'data' => $data
        ]);

        return $contactFournisseur;
    }

    public function delete(ContactFournisseur $contactFournisseur): bool
    {
        return $contactFournisseur->delete();
    }

    public function getByDossier(Dossier $dossier): Collection
    {
        return ContactFournisseur::where('dossier_id', $dossier->id)->get();
    }

    public function getByFournisseur(Fournisseur $fournisseur): Collection
    {
        return ContactFournisseur::where('fournisseur_id', $fournisseur->id)->get();
    }

    public function getModel(): Model
    {
        return new ContactFournisseur();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }

    public function send(ContactFournisseur $contactFournisseur): ContactFournisseur
    {
        $data = $contactFournisseur->data;
        $data['sended'] = true;
        $contactFournisseur->data = $data;
        $contactFournisseur->save();

        return $contactFournisseur;


    }
}
