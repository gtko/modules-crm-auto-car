<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Models\Proformat;

class ProformaDossierDetail extends Component
{
    public $proformat;
    public $dossier;
    public $client;
    public $commercial;

    protected $listeners =
        [
            'refreshProforma' => '$refresh'
        ];

    public function mount(Proformat $proforma, ClientEntity $client, Dossier $dossier)
    {
        $this->proformat = $proforma;
        $this->client = $client;
        $this->dossier = $dossier;
        $this->commercial = $proforma->devis->commercial->id;
    }

    public function save()
    {
        if (Auth::user()->cannot('changeCommercial', Proformat::class)) {
            abort(403);
        }

        $commercial = app(CommercialRepositoryContract::class)->fetchById($this->commercial);
        app(DevisRepositoryContract::class)->changeCommercial($this->proformat->devis, $commercial);

        $this->emit('refreshProforma');

    }

    public function render()
    {
        $commercials = [];
        if (Auth::user()->can('changeCommercial', Proformat::class)) {
            $commercials = app(CommercialRepositoryContract::class)->fetchAll();
        }

        return view('crmautocar::livewire.proforma-dossier-detail',
            [
                'commercials' => $commercials
            ]);
    }
}
