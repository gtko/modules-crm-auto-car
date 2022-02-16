<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;

class DossierCreate extends Component
{
    public $client;
    public $statu;
    public $commercial;
    public $source;

    public $depart_date;
    public $depart_lieu;
    public $arrive_date;
    public $arrive_lieu;

    protected $rules =
        [
            'statu' => 'required',
            'source' => 'required',
            'commercial' => 'required',
            'depart_date' => '',
            'depart_lieu' => '',
            'arrive_date' => '',
            'arrive_lieu' => '',
        ];

    public function mount($client)
    {
        $this->client = $client;
    }


    public function save()
    {
        $this->validate();

        $data =
            [
                'date_depart' => $this->depart_date ?? '',
                'lieu_depart' => $this->depart_lieu ?? '',
                'date_arrivee' => $this->arrive_date ?? '',
                'lieu_arrivee' => $this->arrive_lieu ?? '',
            ];

        $commercial = app(CommercialRepositoryContract::class)->fetchById($this->commercial);
        $source = app(SourceRepositoryContract::class)->fetchById($this->source);
        $statu = app(StatusRepositoryContract::class)->fetchById($this->statu);

        $dossier = app(DossierRepositoryContract::class)->create($this->client, $commercial, $source, $statu, $data);

        return redirect('/clients/' . $this->client->id . '/dossiers/' . $dossier->id);

    }

    public function render()
    {


        $status = app(StatusRepositoryContract::class)->fetchAll();
        $sources = app(SourceRepositoryContract::class)->fetchAll();
        $commercials = app(CommercialRepositoryContract::class)->fetchAll();

        return view('crmautocar::livewire.dossier-create',
            [
                'sources' => $sources,
                'status' => $status,
                'commercials' => $commercials
            ]);
    }
}
