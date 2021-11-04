<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;

class ListCuve extends Component
{

    public function render()
    {
        $dossierRep = app(DossierRepositoryContract::class);
        $sourceRep = app(SourceRepositoryContract::class);

        $dossierRep->setQuery($dossierRep->newQuery()->with(['client.personne.emails', 'client.personne.address.country','commercial.personne', 'source'])
            ->orderByDesc('created_at'));

        $dossiers = $dossierRep->fetchAll();
        $total = $dossiers->total();
        $next = $dossiers->nextPageUrl();
        $prev = $dossiers->previousPageUrl();
        $sources = $sourceRep->fetchAll();

        return view('crmautocar::livewire.list-cuve', compact(['dossiers', 'total', 'next', 'prev', 'sources' ]));
    }
}
