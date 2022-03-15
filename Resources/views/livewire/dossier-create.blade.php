<div>
    <div class="grid grid-cols-2 gap-2">
        <div>
            <x-basecore::inputs.select name="source" wire:model="source" label="Provenance du dossier">
                <option value="">source</option>
                @foreach($sources as $sourceList)
                    <option value="{{$sourceList->id}}">{{$sourceList->label}}</option>
                @endforeach
            </x-basecore::inputs.select>
        </div>
        <div>
            <x-basecore::inputs.select name="commercial" wire:model="commercial" label="Commercial attribué">
                <option value="">Commercial</option>
                @foreach($commercials as $commercialList)
                    <livewire:crmautocar::list-cuve-commercial-detail wire:key="{{$commercialList->id}}" :commercial="$commercialList"/>
                @endforeach
            </x-basecore::inputs.select>
        </div>
        <div>
            <x-basecore::inputs.select name="statu" wire:model="statu" label="Status">
                <option value="">status</option>

                @foreach($status as $statuList)
                    <option value="{{$statuList->id}}">{{$statuList->label}}</option>
                @endforeach
            </x-basecore::inputs.select>
        </div>
    </div>
    <div class="grid grid-cols-2 gap-2 mt-2">
        <div>
            <x-basecore::inputs.date name="depart_date" wire:model="depart_date" label="Date de départ"/>
        </div>
        <div>
            <x-basecore::inputs.text name="depart_lieu" wire:model="depart_lieu" label="Lieu de départ"/>
        </div>
        <div>
            <x-basecore::inputs.date name="arrive_date" wire:model="arrive_date" label="Date de retour"/>
        </div>
        <div>
            <x-basecore::inputs.text name="arrive_lieu" wire:model="arrive_lieu" label="Lieu de retour"/>
        </div>
    </div>
    <span class="btn btn-primary mt-2 cursor-pointer" wire:click='save()'>Sauvegarder</span>

</div>
