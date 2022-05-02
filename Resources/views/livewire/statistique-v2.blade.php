<div>

    <div class="grid grid-cols-3 gap-6 mt-8">
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
    </div>
    <div class="mt-4">
        @if ($this->badge)
            <span class="bg-white py-2 px-4 rounded shadow-md border-black flex flex-row items-center justify-center w-72">
                <span>{{ $this->badge }}</span>
                <span wire:click="clear">@icon('close', null, 'mx-2')</span>
            </span>
        @endif
    </div>
    <x-basecore::loading-replace class="w-full">
        <x-slot name="loader">
            <div class="flex w-full items-start justify-center">
                <div class="flex mt-10 flex-col justify-between items-center">
                    @icon('spinner', null, 'h-16 w-16 animate-spin')
                    <div class="text-xl mt-4">Chargement des statistiques</div>
                </div>
            </div>
        </x-slot>
        @if(Auth::user()->isSuperAdmin() || Auth::user()->hasRole('manager'))
            <livewire:crmautocar::stats-admin-card-global :filtre="$this->filtre" :key="'admin_global_' . $this->key"/>
        @endif

        <livewire:crmautocar::stats-admin-list-commercial :filtre="$this->filtre" :key="'list_commercial' . $this->key"/>
    </x-basecore::loading-replace>

</div>
