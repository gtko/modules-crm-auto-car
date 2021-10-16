<div class="my-4">

    <div class="grid grid-cols-12 gap-4">
        <div class="col-span-3">
            <span>Fournisseur</span>
            <x-basecore::inputs.select name="fournisseurFiltre" wire:model="fournisseursFiltre">
                <option value="" selected="selected">Fournisseur</option>
                @foreach($fournisseursList as $fourni)
                    <option value="{{ $fourni->id }}">{{ $fourni->formatName }}</option>
                @endforeach
            </x-basecore::inputs.select>
        </div>

        <div class="col-span-2">
            <span>Reste à reglé</span>
            <x-basecore::inputs.select name="resteARegler" wire:model="resteARegler">
                <option value="" selected="selected">Reste à regler</option>
                <option value="oui">Oui</option>
                <option value="non">Non</option>
            </x-basecore::inputs.select>
        </div>

        <div class="col-span-2">
            <span>Période du :</span>
            <x-basecore::inputs.date name="periodeStart" wire:model="periodeStart"/>
        </div>

        <div class="col-span-2">
            <span>Au :</span>
            <x-basecore::inputs.date name="periodeEnd" wire:model="periodeEnd"/>
        </div>

        <div class="col-span-2">
            <span>Départ le :</span>
            <x-basecore::inputs.date name="dateDepart" wire:model="dateDepart"/>
        </div>
        <div class="col-span-1">
            <span class="btn btn-primary mt-5" wire:click="clear">Clear</span>
        </div>
    </div>
</div>
