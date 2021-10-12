<div class="grid grid-cols-3 gap-6 mt-8">
    <x-basecore::inputs.date name='debut' wire:model="debut"/>
    <x-basecore::inputs.date name='fin' wire:model="fin"/>
    <x-basecore::button class="w-full" wire:click="filtre">Filtrer</x-basecore::button>
</div>
