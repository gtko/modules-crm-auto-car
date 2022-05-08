<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Http\Livewire\Datatable\ListDemandeFournisseur;
use Modules\CrmAutoCar\Http\Livewire\Datatable\StatFournisseurDatatableQuery;
use Modules\CrmAutoCar\Models\Decaissement;

class StatistiqueFournisseurCard extends Component implements HasTable
{
    use InteractsWithTable;


    protected $queryString = [
        'tableFilters',
        'tableSortColumn',
        'tableSortDirection',
        'tableSearchQuery' => ['except' => ''],
    ];

    protected $listeners = [
        'refreshQuery'
    ];

    public function refreshQuery($datas)
    {
        $this->tableFilters = $datas[0];
        $this->tableSearchQuery = $datas[1];
    }

    protected function getTableQuery(): Builder
    {
        return app(StatFournisseurDatatableQuery::class)->getTableQuery();
    }


    protected function getTableFilters(): array
    {
        return app(StatFournisseurDatatableQuery::class)->getTableFilters();
    }

    public function getTotalAReglerProperty(){
        return $this->getFilteredTableQuery()->sum('prix') ?? 0.00;
    }

    public function getResteAReglerProperty(){
        return $this->totalARegler - $this->DejaRegler;
    }

    public function getDejaReglerProperty(){
        return $this->getFilteredTableQuery()->sum('payer') ?? 0.00;
    }

    public function render()
    {
        return view('crmautocar::livewire.statistique-fournisseur-card');
    }
}
