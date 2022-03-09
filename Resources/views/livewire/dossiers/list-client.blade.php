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
            <div class="mt-2">
                <div class="btn-sm btn-primary mt-3 w-32 rounded cursor-pointer" wire:click="clearFiltre()">Clear
                    les
                    filtres
                </div>
            </div>
            @can('viewAll', Dossier::class)
            <div class="mt-5">
                <x-basecore::inputs.checkbox wire:model="viewMyLead" name="my_lead" label="Voir mes dossiers uniquement"/>
            </div>
            @endcan
        </div>

    </div>
    <div class="overflow-auto lg:overflow-visible mt-8 sm:mt-0">
        <table class="table table-report sm:mt-2">
            <thead>
            <tr>
                <th class="whitespace-nowrap"></th>
                <th class="whitespace-nowrap">Ref</th>
                <th class="text-center whitespace-nowrap">Nom</th>
                <th class="text-center whitespace-nowrap">Statut</th>
                <th class="text-center whitespace-nowrap">tags</th>
                <th class="text-center whitespace-nowrap">date du voyage</th>
                @if($resa)
                    <th class="text-center whitespace-nowrap">Gestionnaires</th>
                @else
                    <th class="text-center whitespace-nowrap">Commercial</th>
                @endif
                <th class="text-center whitespace-nowrap">Créer le</th>
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
