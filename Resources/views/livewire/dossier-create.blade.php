<div>
    <div class="grid grid-cols-2 gap-2">
        <x-basecore::inputs.select name="source" wire:model="source">
            <option value="">source</option>
            @foreach($sources as $sourceList)
                <option value="{{$sourceList->id}}">{{$sourceList->label}}</option>
            @endforeach
        </x-basecore::inputs.select>
        <x-basecore::inputs.select name="commercial" wire:model="commercial">
            <option value="">Commercial</option>
            @foreach($commercials as $commercialList)
                <option value="{{$commercialList->id}}">{{$commercialList->format_name}}</option>
            @endforeach
        </x-basecore::inputs.select>
        <x-basecore::inputs.select name="statu" wire:model="statu">
            <option value="">status</option>
            @foreach($status as $statuList)
                <option value="{{$statuList->id}}">{{$statuList->label}}</option>
            @endforeach
        </x-basecore::inputs.select>
    </div>
    <div class="grid grid-cols-2 gap-2 mt-2">
        <div>
            <x-basecore::inputs.date name="depart_date" wire:model="depart_date" label="Date de départ"/>
        </div>
        <div>
            <x-basecore::inputs.text name="depart_lieu" wire:model="depart_lieu" label="Lieu de départ"/>
        </div>
        <div>
            <x-basecore::inputs.date name="arrive_date" wire:model="arrive_date" label="Date arrivée"/>
        </div>
        <div>
            <x-basecore::inputs.text name="arrive_lieu" wire:model="arrive_lieu" label="Lieu arrivée"/>
        </div>
    </div>
    <span class="btn btn-primary mt-2 cursor-pointer" wire:click='save()'>Save</span>

</div>
