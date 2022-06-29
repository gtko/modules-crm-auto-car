<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
        <div class="box bg-theme-1 p-5 mt-6">
            <div class="pt-3 text-white" x-data="{selected:{{ Auth::Commercial()->id }}}">
                @foreach($users as $name => $commercials)
                    @if (Auth::user()->IsSuperAdmin() || Auth::user()->hasRole("manager"))
                        <h2 class="mb-2 text-xl font-bold">{{$name}}</h2>
                    @endif
                    <div class="mb-4">
                        @foreach($commercials as $commercial)
                            @if (Auth::user()->IsSuperAdmin() || Auth::user()->hasRole("manager") || Auth::Commercial()->id == $commercial->id)
                                <span
                                    class="flex items-center py-2 rounded-md @if($this->commercial_id == $commercial->id) bg-theme-25 @endif pr-4 pl-2 dark:bg-dark-1 font-medium cursor-pointer">
{{--                         <span--}}
{{--                             x-on:click="selected !== {{ $commercial->id }} ? selected = {{ $commercial->id }} : selected = null"--}}
{{--                             x-show="selected == {{ $commercial->id }}">@icon('chevronDown', null, 'mr-2')</span>--}}
{{--                        <span--}}
{{--                            x-on:click="selected !== {{ $commercial->id }} ? selected = {{ $commercial->id }} : selected = null"--}}
{{--                            x-show="selected != {{ $commercial->id }}">@icon('chevronRight', null, 'mr-2')</span>--}}
                        <span class="flex justify-between w-full items-center">
                            <span class="pt-1" wire:click="selectCommercial({{$commercial->id}})">
                                @if(strlen($commercial->formatName) > 18)
                                    {{ substr($commercial->formatName  , 0, 18) . '...' }}
                                @else
                                    {{ $commercial->formatName }}
                                @endif
                            </span>

                            @if ($commercial->isActif)
                                <div class="w-2 h-2 bg-green-600 rounded-full"></div>
                            @else
                                <div class="w-2 h-2 bg-red-600 rounded-full"></div>
                            @endif
                        </span>

                    </span>
                                <div x-show="selected === {{ $commercial->id }}">
                                    {{--                                <livewire:crmautocar::plateau-list-detail :commercialId="$commercial->id" :key="$name . '_' .$commercial->id"/>--}}
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-span-12 relative lg:col-span-9 xxl:col-span-10">
        <x-basecore::loading-replace class="w-full">
            <x-slot name="loader">
                <div class="flex absolute inset-0 items-start justify-center">
                    <div class="flex mt-10 flex-col justify-between items-center">
                        @icon('spinner', null, 'h-16 w-16 animate-spin')
                        <div class="text-xl mt-4">Chargement des statistiques de l'utilisateur</div>
                    </div>
                </div>
            </x-slot>
                        <livewire:crmautocar::stats-admin-card :filtre="$this->filtre" :key="'admin_card'.$this->key"/>
            <livewire:crmautocar::stat-admin-client-list :filtre="$this->filtre" :key="'client_list'.$this->key"/>
        </x-basecore::loading-replace>
    </div>
</div>
