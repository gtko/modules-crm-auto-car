<div>

    <div class="grid grid-cols-3 gap-6 mt-8">
        @if (\Auth::user()->isSuperAdmin())
            <x-basecore::inputs.select name="bureau" class="form-control-sm" wire:model="bureau">
                <option value="">Bureau</option>
                @foreach ($bureauxList as $bureau)
                    <option value="{{ $bureau->id }}">{{ $bureau->name }}</option>
                @endforeach
            </x-basecore::inputs.select>
        @endif
        <x-basecore::inputs.date name='debut' wire:model="debut" />
        <x-basecore::inputs.date name='fin' wire:model="fin" />
    </div>
    <div class="mt-4">
        @if ($this->badge)
            <span
                class="flex flex-row items-center justify-center px-4 py-2 bg-white border-black rounded shadow-md w-72">
                <span>{{ $this->badge }}</span>
                <span wire:click="clear">@icon('close', null, 'mx-2')</span>
            </span>
        @endif
    </div>

    <div>

    </div>

    @if (Auth::user()->isSuperAdmin() || Auth::user()->hasRole('manager'))
        <div>
            <div class="sm:hidden">
                <label for="tabs" class="sr-only">Select a tab</label>
                <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                <select id="tabs" name="tabs" wire:model="tab"
                    class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <option value="stats">Statistique global</option>
                    <option value="horaire">Horaires</option>
                    <option value="plateau">Etat du plateau</option>
                    <option value="attributions">Attributions</option>
                </select>
            </div>
            <div class="hidden sm:block">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px space-x-8" aria-label="Tabs">
                        <div class="@if ($tab === 'stats') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif cursor-pointer whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                            wire:click="$set('tab', 'stats')"> Statistique global</div>
                        <div class="@if ($tab === 'horaire') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif cursor-pointer whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                            wire:click="$set('tab', 'horaire')"> Horaires </div>
                        <div class="@if ($tab === 'plateau') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif cursor-pointer whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                            wire:click="$set('tab', 'plateau')"> Etat du plateau</div>
                        <div class="@if ($tab === 'attributions') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif cursor-pointer whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm"
                            wire:click="$set('tab', 'attributions')"> Attributions</div>
                    </nav>
                </div>
            </div>
        </div>
    @endif



    <x-basecore::loading-replace class="w-full">
        <x-slot name="loader">
            <div class="flex items-start justify-center w-full">
                <div class="flex flex-col items-center justify-between mt-10">
                    @icon('spinner', null, 'h-16 w-16 animate-spin')
                    <div class="mt-4 text-xl">Chargement des statistiques</div>
                </div>
            </div>
        </x-slot>

        @if ($tab === 'stats')
            stats
            {{--        @if (Auth::user()->isSuperAdmin() || Auth::user()->hasRole('manager')) --}}
            {{--            <livewire:crmautocar::stats-admin-card-global :filtre="$this->filtre" :key="'admin_global_' . $this->key"/> --}}
            {{--        @endif --}}
        @endif

        @if ($tab === 'plateau')
            @if (Auth::user()->isSuperAdmin() || Auth::user()->hasRole('manager'))
                <livewire:crmautocar::stat-etat-plateau />
            @endif
        @endif

        @if ($tab === 'attributions')
            @if (Auth::user()->isSuperAdmin() || Auth::user()->hasRole('manager'))
                <livewire:crmautocar::stat-attributions :filtre="$this->filtre" :key="'List_attribution' . $this->key" />
            @endif
        @endif


        @if ($tab === 'horaire')
            <livewire:crmautocar::stats-admin-list-commercial :filtre="$this->filtre" :key="'list_commercial' . $this->key" />
        @endif
    </x-basecore::loading-replace>


</div>
