<div>
    <div class="col-span-12 mt-6">
        <div class="mt-4 grid grid grid-cols-4 gap-4">
            <x-basecore::inputs.text name="nom_client" placeholder="Nom du client" class="form-control-sm"
                                     wire:model="nom_client"/>


            <x-basecore::inputs.select name="statut" class="form-control-sm" wire:model="status">
                <option value="">Statut</option>
                @foreach($pipelineList as $pipeline)
                    <optgroup label="{{ $pipeline->first()->pipeline->name ?? '' }}">
                        <optgroup label="{{ $pipeline->first()->pipeline->name ?? '' }}">
                            @foreach($pipeline as $statu)
                                <option value="{{$statu->id}}">{{$statu->label}}</option>
                            @endforeach
                        </optgroup>
                @endforeach
            </x-basecore::inputs.select>

            <x-basecore::inputs.select name="tag" class="form-control-sm" wire:model="tag">
                <option value="">Tag</option>
                @foreach($tagList as $tagLi)
                    <option value="{{$tagLi->id}}">{{$tagLi->label}}</option>
                @endforeach
            </x-basecore::inputs.select>
            @if(\Auth::user()->isSuperAdmin())
                <x-basecore::inputs.select name="commercial" class="form-control-sm" wire:model="commercial">
                    <option value="">Commercial</option>
                    @foreach($commercialList as $commer)
                        <option value="{{$commer->id}}">{{$commer->format_name}}</option>
                    @endforeach
                </x-basecore::inputs.select>
            @endif

        </div>
        <div class="mt-4 grid grid grid-cols-4 gap-4">
            <div>
                <span>Depart</span>
                <x-basecore::inputs.date name="date_de_depart_debut" class="form-control-sm"
                                         wire:model="departStart"/>
            </div>
            <div>
                <span>Retour</span>
                <x-basecore::inputs.date name="date_de_depart_fin" class="form-control-sm" wire:model="departEnd"/>
            </div>
            <div>
                <span>Date de signature</span>
                <x-basecore::inputs.date name="data_signature" class="form-control-sm" wire:model="dateSignatrue"/>
            </div>

            <div class="mt-2">
                <div class="btn-sm btn-primary mt-3 w-32 rounded cursor-pointer" wire:click="clearFiltre()">Clear
                    les
                    filtres
                </div>
            </div>
            @can('viewAll', \Modules\CoreCRM\Models\Dossier::class)
                <div class="mt-5">
                    <x-basecore::inputs.checkbox wire:model="viewMyLead" name="my_lead"
                                                 label="Voir mes dossiers uniquement"/>
                </div>
            @endcan

        </div>
    </div>
    <div class="overflow-auto lg:overflow-visible mt-8 sm:mt-0">
        <table class="table table-report sm:mt-2">
            <thead>
            <tr>
                <th class="whitespace-nowrap"></th>
                <x-crmautocar::colsort wire:click="sort('id')"
                                       class="text-center whitespace-nowrap"
                                       :active="$order === 'id'"
                                       :sort="$direction"
                >
                    Ref
                </x-crmautocar::colsort>
                <x-crmautocar::colsort wire:click="sort('format_name')"
                                       class="justify-center text-center whitespace-nowrap"
                                       :active="$order === 'format_name'"
                                       :sort="$direction"
                >
                    Nom
                </x-crmautocar::colsort>
                <x-crmautocar::colsort wire:click="sort('company')"
                                       class="justify-center text-center whitespace-nowrap"
                                       :active="$order === 'company'"
                                       :sort="$direction"
                >
                    Société
                </x-crmautocar::colsort>
                <x-crmautocar::colsort wire:click="sort('statut')"
                                       class="justify-center text-center whitespace-nowrap"
                                       :active="$order === 'statut'"
                                       :sort="$direction"
                >
                    Statut
                </x-crmautocar::colsort>
                <th class="text-center whitespace-nowrap">tags</th>
                <x-crmautocar::colsort wire:click="sort('date_voyage')"
                                       class="justify-center text-center whitespace-nowrap"
                                       :active="$order === 'date_voyage'"
                                       :sort="$direction"
                >
                    Date du voyage
                </x-crmautocar::colsort>
                @if($resa)
                    <x-crmautocar::colsort wire:click="sort('gestionnaire')"
                                           class="justify-center text-center whitespace-nowrap"
                                           :active="$order === 'gestionnaire'"
                                           :sort="$direction"
                    >
                        Gestionnaires
                    </x-crmautocar::colsort>
                @endif
                <x-crmautocar::colsort wire:click="sort('commercial')"
                                       class="justify-center text-center whitespace-nowrap"
                                       :active="$order === 'commercial'"
                                       :sort="$direction"
                >
                    Commercial
                </x-crmautocar::colsort>
                <x-crmautocar::colsort wire:click="sort('created_at')"
                                       class="justify-center text-center whitespace-nowrap"
                                       :active="$order === 'created_at'"
                                       :sort="$direction"
                >
                    Créer le
                </x-crmautocar::colsort>
                <th class="text-center whitespace-nowrap"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($dossiers as $dossier)
                <livewire:crmautocar::dossiers.list-detail :resa="$resa" :dossier="$dossier" :key="$dossier->id"/>
            @endforeach
            </tbody>
        </table>

    </div>
    {{$dossiers->links()}}
</div>
