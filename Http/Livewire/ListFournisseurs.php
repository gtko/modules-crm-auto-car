<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Filament\Tables\Actions\IconButtonAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Tagfournisseur;
use Modules\CrmAutoCar\Models\Dossier;
use Modules\CrmAutoCar\Models\Fournisseur;
use Modules\CrmAutoCar\Tables\Columns\TagsTable;

class ListFournisseurs extends Component implements HasTable
{
    use InteractsWithTable;

    protected $queryString = [
        'tableFilters',
        'tableSortColumn',
        'tableSortDirection',
        'tableSearchQuery' => ['except' => ''],
    ];

    /**
     * @var FournisseurRepositoryContract
     */
    protected $repository = null;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->repository =  app(FournisseurRepositoryContract::class);
    }

    protected function getTableQuery(): Builder
    {
        $query = $this->repository->disabled()->newQuery();

        return $query;
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('company')
                ->label('Société')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            TextColumn::make('format_name')
                ->label('Fournisseur')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            TextColumn::make('phone')
                ->label('Téléphone')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            TextColumn::make('data->astreinte')
                ->label('Astreinte')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            TagsTable::make('tagfournisseurs')
                ->label('Catégories')
                ->toggleable(true),
            ViewColumn::make('id')
                ->label('Activé')
                ->view('crmautocar::user-switch')
        ];
    }

    protected function getTableActions(): array
    {
        return [
            IconButtonAction::make('edit')
                ->label('Editer le fournisseur')
                ->tooltip('Editer le fournisseur')
                ->url(fn(Fournisseur $record): string => route('fournisseurs.edit', [$record]))
                ->icon('heroicon-o-pencil'),
        ];
    }

    protected function applySortingToTableQuery(Builder $query): Builder
    {
        if (filled($sortCol = $this->getTableSortColumn()) && filled($sortDir = $this->getTableSortDirection())) {

            $ordersBy = [
                'format_name' => function ($query, $direction) {
                    $query->orderBy(function ($query) {
                        $query
                            ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                            ->from('personnes')
                            ->whereColumn('personnes.id', 'users.personne_id')
                            ->limit(1);
                    }, $direction);
                },
            ];

            if (($ordersBy[$sortCol] ?? false) && is_callable($ordersBy[$sortCol])) {
                $direction = $sortDir;
                $ordersBy[$sortCol]($query, $direction);
            } else {
                $columnName = $this->tableSortColumn;

                if (!$columnName) {
                    return $query;
                }

                $direction = $this->tableSortDirection ?? 'asc';

                $column = $this->getCachedTableColumn($columnName);

                if (!$column) {
                    return $query->orderBy($columnName, $direction);
                }

                $column->applySort($query, $direction);

                return $query;
            }

        }

        return $query;
    }

    protected function applySearchToTableQuery(Builder $query): Builder
    {
        if (filled($searchQuery = $this->getTableSearchQuery())) {
            $query->where(function (Builder $query) use ($searchQuery) {
                $query->setQuery(
                    $this->repository->searchQuery($query, $searchQuery)
                        ->getQuery()
                );
            });
        }

        return $query;
    }

    protected function getTableFilters(): array
    {
        $filters = [
            MultiSelectFilter::make('tagfournisseurs')
                ->label('Catégories')
                ->options(fn() => Tagfournisseur::all()->pluck('name', 'id'))
                ->column('source_id'),
            SelectFilter::make('enabled')
                ->label('Actif')
                ->options(fn() => [
                    '1' => 'Actif',
                    '0' => 'Inactif',
                ])
                ->column('enabled'),
        ];

        return $filters;
    }

    public function render()
    {
        return view('crmautocar::livewire.list-fournisseurs');
    }
}
