<div>
    <div class="grid grid-cols-3 gap-6 mt-8">
        <x-basecore::inputs.date name='debut' wire:model="debut"/>
        <x-basecore::inputs.date name='fin' wire:model="fin"/>
        <x-basecore::button class="w-full" wire:click="filtre">Filtrer</x-basecore::button>
    </div>
    <div class="mt-4">
        @if ($this->badge)
            <span class="bg-white py-2 px-4 rounded shadow-md border-black flex flex-row items-center justify-center w-72">
                <span>{{ $this->badge }}</span>
                <span wire:click="clear">@icon('close', null, 'mx-2')</span>

            </span>
        @endif
    </div>
</div>
