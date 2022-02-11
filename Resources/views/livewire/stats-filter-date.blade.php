<div>
    <div class="grid grid-cols-3 gap-6 mt-8">
        <x-basecore::inputs.select name="mois" wire:model="mois">
            <option value="">Mois</option>
            @foreach ($listMois as $dt)
                <option value="{{$dt->format("Y-m")}}">{{ $dt->translatedFormat('F Y') }}</option>
            @endforeach

        </x-basecore::inputs.select>

        <x-basecore::button class="w-full" wire:click="filtre">Filtrer</x-basecore::button>
    </div>
    <div class="mt-4">
        @if ($this->badge)
            <span
                class="bg-white py-2 px-4 rounded shadow-md border-black flex flex-row items-center justify-center w-72">
                <span>{{ $this->badge }}</span>
                <span wire:click="clear">@icon('close', null, 'mx-2')</span>

            </span>
        @endif
    </div>
</div>
