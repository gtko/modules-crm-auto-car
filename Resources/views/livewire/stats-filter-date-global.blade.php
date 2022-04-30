<div>
    <div class="grid grid-cols-4 gap-6 mt-8">
        @if(\Auth::user()->isSuperAdmin())
            <x-basecore::inputs.select name="bureau" class="form-control-sm" wire:model="bureau">
                <option value="">Bureau</option>
                @foreach($bureauxList as $bureau)
                    <option value="{{$bureau->id}}">{{$bureau->name}}</option>
                @endforeach
            </x-basecore::inputs.select>
        @endif
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
