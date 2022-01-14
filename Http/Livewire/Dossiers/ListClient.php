<?php

namespace Modules\CrmAutoCar\Http\Livewire\Dossiers;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;

class ListClient extends Component
{

    public $nom_client = '';
    public $status;
    public $tag;
    public $commercial;
    public $departStart;
    public $departEnd;

    protected $rules = [
        'nom_client' => '',
        'status' => '',
        'commercial' => '',
    ];


    public function search()
    {

        $dossierRep = app(DossierRepositoryContract::class);
        if($this->status || $this->commercial || $this->tag)
        {
            $dossierRep->setQuery($dossierRep->newQuery()
                ->where('status_id', $this->status)
                ->orWhere('commercial_id', $this->commercial)
                ->orWhereHas('devis', function($query){
                   $query->whereJsonContains('data', 'test');
                })
                ->orWhereHas('tags', function($query){
                    $query-where('id', $this->tag);
                })
            );

        }

        return $dossierRep->fetchSearch($this->nom_client ?? null);
    }

    public function render()
    {
        return view('crmautocar::livewire.dossiers.list-client',
            [
                'dossiers' => $this->search(),
                'statusList' => app(StatusRepositoryContract::class)->fetchAll(),
                'commercialList' => app(CommercialRepositoryContract::class)->fetchAll(),
                'tagList' => app(TagsRepositoryContract::class)->fetchAll()
            ]);
    }
}
