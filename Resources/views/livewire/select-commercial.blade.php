<div>
    <div class="flex flex-col">
        <span class="ml-1">Dossier suivi par :</span>
        <div class="flex flex-row  space-x-1 mx-1">
            <div class="w-5/6">
                <x-basecore::inputs.select name="select_commercial" wire:model="commercialSelect"
                                           class="form-control-sm">
                    @foreach($commercialsList as $commercial)
                        <option value="{{$commercial->id}}">{{$commercial->format_name}}</option>
                    @endforeach
                </x-basecore::inputs.select>
            </div>

            <button wire:click="changerCommercial()" class="btn btn-primary form-control-sm">Valider</button>
        </div>
    </div>
</div>
