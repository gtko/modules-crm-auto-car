<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;
use Modules\CrmAutoCar\Models\Dossier;
use Modules\CrmAutoCar\Models\Tag;
use Modules\CrmAutoCar\Repositories\DossierAutoCarRepository;

class ListFormulaire extends Component implements Tables\Contracts\HasTable
{

    use Tables\Concerns\InteractsWithTable;

    public $date;

    protected $queryString = [
        'date',
        'tableFilters',
        'tableSortColumn',
        'tableSortDirection',
        'tableSearchQuery' => ['except' => ''],
    ];

    protected $repository = null;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->repository =  app(DossierAutoCarRepository::class);
    }

    protected function getTableQuery(): Builder
    {
        $query = $this->repository->newQuery()
        ->whereHas('status', function($query){
            $query->where('id', 4);
        });

        return $query;
    }


    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('client.format_name')
                ->label('Client')
                ->sortable(['clients.personnes.firstname', 'clients.personnes.lastname'])
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('source.label')
                ->label('Source')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('client.email')
                ->label('Email')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('client.phone')
                ->label('Téléphone')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            Tables\Columns\ImageColumn::make('commercial.avatar_url')
                ->label('Commercial')
                ->tooltip(fn(Model $record): string => "{$record->commercial->format_name}")
                ->rounded()
                ->sortable()
                ->searchable()
                ->alignCenter()
                ->extraAttributes([
                    'class' => 'flex justify-center items-center'
                ])
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('created_at')
                ->label('Date de reception')
                ->sortable()
                ->searchable()
                ->dateTime()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('date_depart')
                ->label('Date de départ')
                ->sortable()
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('lieu_depart')
                ->label('Lieu de départ')
                ->sortable(['data->lieu_depart'])
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('pax_dep')
                ->label("PAX dep")
                ->sortable(['data->pax_dep'])
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('date_arrive')
                ->label("Date d'arrivée")
                ->sortable()
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('lieu_arrive')
                ->label("Lieu d'arrivée")
                ->sortable(['data->lieu_arrivee'])
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('pax_ret')
                ->label("PAX Ret")
                ->sortable(['data->pax_ret'])
                ->searchable()
                ->toggleable(true),
            Tables\Columns\TextColumn::make('type_trajet')
                ->label("Type")
                ->sortable(['data->type_trajet'])
                ->searchable()
                ->toggleable(true),

        ];
    }

    protected function applySortingToTableQuery(Builder $query): Builder
    {
        if (filled($sortCol = $this->getTableSortColumn()) && filled($sortDir = $this->getTableSortDirection())) {

            $ordersBy = [
                'date_depart' => function($query, $direction) {
                    return $query->orderByRaw("STR_TO_DATE(json_unquote(json_extract(data, '$.date_depart')), '%d/%c/%Y') $direction");
                },
                'date_arrive' => function($query, $direction) {
                    return $query->orderByRaw("STR_TO_DATE(json_unquote(json_extract(data, '$.date_arrive')), '%d/%c/%Y') $direction");
                },
                'client.format_name' => function($query, $direction) {
                    $query->orderBy(function($query){
                        $query
                            ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                            ->from('clients')
                            ->leftJoin('personnes', 'personnes.id', '=', 'clients.personne_id')
                            ->whereColumn('clients.id','dossiers.clients_id')
                            ->limit(1);
                    }, $direction);
                },
                'client.email' => function($query, $direction) {
                    $query->orderBy(function($query){
                        $query->select('emails.email')
                            ->from('clients')
                            ->join('personnes', 'personnes.id', '=', 'clients.personne_id')
                            ->join('email_personne', 'email_personne.personne_id', '=', 'personnes.id')
                            ->join('emails', 'email_personne.email_id', '=', 'emails.id')
                            ->whereColumn('clients.id','dossiers.clients_id')
                            ->limit(1);
                    }, $direction);
                },
                'client.phone' => function($query, $direction) {
                    $query->orderBy(function($query){
                        $query->select('phones.phone')
                            ->from('clients')
                            ->join('personnes', 'personnes.id', '=', 'clients.personne_id')
                            ->join('personne_phone', 'personne_phone.personne_id', '=', 'personnes.id')
                            ->join('phones', 'personne_phone.phone_id', '=', 'phones.id')
                            ->whereColumn('clients.id','dossiers.clients_id')
                            ->limit(1);
                    }, $direction);
                },
                'commercial.format_name' => function($query, $direction) {
                    $query->orderBy(function($query){
                        $query
                            ->select(DB::raw('CONCAT(personnes.firstname,personnes.lastname) as format_name'))
                            ->from('users')
                            ->leftJoin('personnes', 'personnes.id', '=', 'users.personne_id')
                            ->whereColumn('users.id','dossiers.commercial_id')
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

    protected function getTableRecordUrlUsing(): \Closure
    {
        return fn(Model $record): string => route('dossiers.show', ['client' => $record->client, 'dossier' => $record]);
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
            Tables\Filters\MultiSelectFilter::make('source')
                ->options(fn() => Source::all()->pluck('label', 'id'))
                ->column('source_id'),
            Tables\Filters\SelectFilter::make('etat')
                ->label('Etat')
                ->options(fn() => [
                    'waiting' => 'En attente',
                    'distribue' => 'Distribué',
                    'corbeille' => 'Corbeille'
                ])
                ->query(function ($query, $data) {
                    if($data['value']) {
                        $retour = match ($data['value']) {
                            'corbeille' => fn($query) => $query->onlyTrashed(),
                            'distribue' => fn($query) => $query->where('commercial_id', '!=', '1'),
                            'waiting' => fn($query) => $query->where('commercial_id', '=', '1'),
                        };

                        return $retour($query);
                    }
                })->default('waiting'),

        ];

        return $filters;
    }

    protected function getTableActions(): array
    {
        return [
            Tables\Actions\IconButtonAction::make('edit')
                ->label('Voir le dossier')
                ->tooltip('Voir le dossier')
                ->url(fn(Dossier $record): string => route('dossiers.show', [$record->client, $record]))
                ->icon('heroicon-o-eye'),
            Tables\Actions\IconButtonAction::make('Supprimer')
                ->action(fn ($record) => $record->delete())
                ->requiresConfirmation()
                ->tooltip('Supprimer le dossier')
                ->color('danger')
                ->icon('heroicon-o-trash'),
        ];
    }


    public static function getActionBulkAttribution(){
        return Tables\Actions\BulkAction::make('attribution')
            ->action(function ($records, array $data): void {
                foreach ($records as $record) {
                    $record->commercial()->associate($data['commercialID']);
                    $record->attribution = Carbon::now();
                    $record->save();
                }
            })
            ->icon('gmdi-assignment-ind-r')
            ->modalButton('Attribuer les dossiers')
            ->deselectRecordsAfterCompletion()
            ->form([
                Select::make('commercialID')
                    ->label('Commercial')
                    ->options(function(){
                        $commercials = app(CommercialRepositoryContract::class)
                            ->newQuery()
                            ->where('enabled', true)
                            ->role('commercial')
                            ->get();

                        return $commercials->map(function($commercial){
                            $commercialRepo = app(CommercialRepositoryContract::class);
                            $countDossierByDay = $commercialRepo->countClientByDays($commercial);
                            $countDossierByMounth = $commercialRepo->countClientByMounth($commercial);
                            return [
                                'label' => $commercial->format_name . ' (' . $countDossierByDay . ' / ' . $countDossierByMounth . ')',
                                'id' => $commercial->id,
                            ];
                        })->pluck('label', 'id');
                    })
                    ->required(),
            ]);
    }

    protected function getTableBulkActions(): array
    {
        return [
            self::getActionBulkAttribution(),
            Tables\Actions\BulkAction::make('delete')
                ->action(fn ($records) => $records->each->delete())
                ->deselectRecordsAfterCompletion()
                ->requiresConfirmation()
                ->color('danger')
                ->icon('heroicon-o-trash'),
        ];
    }

    public function render()
    {
        return view('crmautocar::livewire.datatable.list-dossier');
    }
}
