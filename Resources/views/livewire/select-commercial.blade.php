<div>
    <div class="flex flex-col p-5">
        <span class="ml-1">Dossier suivi par :</span>
        <div class="flex flex-row space-x-1">
            @if (Auth::user()->can('changeCommercial', Modules\CrmAutoCar\Models\Proformat::class))
                <div class="w-5/6">
                    <x-basecore::inputs.select name="select_commercial" wire:model="commercialSelect"
                                               class="form-control-sm">
                        @foreach($commercialsList as $commercial)
                            <option value="{{$commercial->id}}">{{$commercial->format_name}}</option>
                        @endforeach
                    </x-basecore::inputs.select>
                </div>
                <button wire:click="changerCommercial()" class="btn btn-primary form-control-sm">Valider</button>
            @else
                <div class="w-5/6">
                    <x-basecore::inputs.select name="select_commercial" disabled="disabled"
                                               class="form-control-sm">
                        @foreach($commercialsList as $commercial)
                            <option value="{{$commercial->id}}">{{$commercial->format_name}}</option>
                        @endforeach
                    </x-basecore::inputs.select>
                </div>
            @endif
        </div>
    </div>
</div>
