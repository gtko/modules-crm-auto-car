<div>
    <div class="col-span-12 mt-6">
        <div class="intro-y block sm:flex items-center h-10">
            <div class="btn btn-primary">
                <a href="{{route('clients.create')}}">Ajouter une client</a>
            </div>

        </div>
        <div class="mt-4 grid grid grid-cols-4 gap-4">
            <x-basecore::inputs.text name="nom_client" placeholder="Nom du client" class="form-control-sm"
                                     wire:model="nom_client"/>
            <x-basecore::inputs.select name="statut" class="form-control-sm" wire:model="status">
                <option value="">Statut</option>
                @foreach($statusList as $statu)
                    <option value="{{$statu->id}}">{{$statu->label}}</option>
                @endforeach

            </x-basecore::inputs.select>
            <x-basecore::inputs.select name="tag" class="form-control-sm">
                <option value="">Tag</option>
            </x-basecore::inputs.select>
            <x-basecore::inputs.select name="commercial" class="form-control-sm">
                <option value="">Commercial</option>
            </x-basecore::inputs.select>
            <div>
                <span>Depart Du</span>
                <x-basecore::inputs.date name="date_de_depart_debut" class="form-control-sm"/>
            </div>
            <div>
                <span>Aux</span>
                <x-basecore::inputs.date name="date_de_depart_fin" class="form-control-sm"/>
            </div>
        </div>
        <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
            <table class="table table-report sm:mt-2">
                <thead>
                <tr>
                    <th class="whitespace-nowrap"></th>
                    <th class="whitespace-nowrap">Ref</th>
                    <th class="text-center whitespace-nowrap">Nom</th>
                    <th class="text-center whitespace-nowrap">Statut</th>
                    <th class="text-center whitespace-nowrap">Commercial</th>
                    <th class="text-center whitespace-nowrap">Créer le</th>
                    <th class="text-center whitespace-nowrap"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($dossiers as $dossier)

                    <livewire:crmautocar::dossiers.list-detail :dossier="$dossier" :key="$dossier->id"/>
                @endforeach
                </tbody>
            </table>
        </div>

        {{$dossiers->links()}}

    </div>
</div>
