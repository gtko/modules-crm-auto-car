<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\MultiSelectFilter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Status;
use Modules\CrmAutoCar\Models\Tag;
use Modules\CrmAutoCar\Tables\Columns\BureauColumn;
use Modules\CrmAutoCar\Tables\Columns\TagsTable;

class StatAttributions extends Component implements HasTable
{

    use InteractsWithTable;

    protected $queryString = [
        'tableFilters',
        'tableSortColumn',
        'tableSortDirection',
        'tableSearchQuery' => ['except' => ''],
        'debut',
        'fin',
        'bureau'
    ];

    public $bureau = '';
    public $debut = '';
    public $fin = '';

    public $count = 0;

    protected $repository = null;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->repository =  app(DossierRepositoryContract::class);
    }

    public function mount($filtre)
    {
        $this->debut = $filtre['debut'] ?? null;
        $this->fin = $filtre['fin'] ?? null;
        $this->bureau = $filtre['bureau'] ?? null;
    }


    protected function getTableQuery(): Builder
    {
        $query = $this->repository->newQuery();

        if ($this->debut) {
            $query->whereDate('attribution', '>=', $this->debut);
        }

        if ($this->fin) {
            $query->whereDate('attribution', '<=', $this->fin);
        }

        return $query;
    }


    protected function getTableColumns(): array
    {
        return [
            ImageColumn::make('client.avatar_url')
                ->label('')
                ->rounded(true),
            BureauColumn::make('commercial.roles')
                ->label('Bureau')
                ->toggleable(\Auth::user()->isSuperAdmin(), isToggledHiddenByDefault: true),

            TextColumn::make('ref')
                ->label('Ref')
                ->sortable(['dossiers.id'])
                ->searchable()
                ->toggleable(true),

            TextColumn::make('client.format_name')
                ->label('Client')
                ->sortable()
                ->searchable()
                ->toggleable(true),

            TextColumn::make('client.company')
                ->label('Société')
                ->default('N/A')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            TextColumn::make('status.label')
                ->label('Statut')
                ->extraAttributes(function (...$params) {
                    return [
                        'style' => 'background-color:' . $params[2]->status->color,
                        'class' => 'text-white rounded'
                    ];
                })
                ->sortable()
                ->toggleable(true),

            TagsTable::make('tags')
                ->label('Tags')
                ->toggleable(true),


            ImageColumn::make('commercial.avatar_url')
                ->label('Commercial')
                ->tooltip(fn (Model $record): string => "{$record->commercial->format_name}")
                ->rounded()
                ->sortable()
                ->searchable()
                ->alignCenter()
                ->extraAttributes([
                    'class' => 'flex justify-center items-center'
                ])
                ->toggleable(true),

            TextColumn::make('attribution')
                ->label('attribué le')
                ->dateTime()
                ->sortable()
                ->toggleable(true),

        ];
    }

    protected function getTableFilters(): array
    {
        $filters = [

            SelectFilter::make('status')
                ->options(fn () => Status::all()->pluck('label', 'id'))
                ->attribute('status_id'),
            MultiSelectFilter::make('tag')
                ->options(fn () => Tag::all()->pluck('label', 'id'))
                ->query(function ($query, $data) {
                    if (count($data['values']) > 0) {
                        return $query->whereHas('tags', function (Builder $query) use ($data) {
                            $query->whereIn('tag_id', $data['values']);
                        });
                    }
                })
        ];

        if (
            \Auth::user()->isSuperAdmin() ||
            \Auth::user()->can('changeCommercial', \Modules\CrmAutoCar\Models\Proformat::class)
        ) {
            $filters[] = SelectFilter::make('commercial')
                ->options(fn () => Commercial::role('commercial')->get()->pluck('format_name', 'id'))
                ->query(function ($query, $data) {
                    if ($data['value'] ?? false) {
                        return $query->where('commercial_id', $data['value']);
                    }
                });
        }

        return $filters;
    }

    public function render()
    {

        $this->count = $this->getFilteredTableQuery()->count();

        return view('crmautocar::livewire.stat-attributions');
    }
}
