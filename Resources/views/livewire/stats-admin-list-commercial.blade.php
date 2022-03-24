<div class="box bg-theme-1 p-5 mt-6">
    <div class="pt-3 text-white" x-data="{selected:{{ Auth::Commercial()->id }}}">

        @foreach($this->commercials as $commercial)
            @if (Auth::user()->IsSuperAdmin() || Auth::Commercial()->id == $commercial->id)
                <span
                    class="flex items-center py-2 rounded-md @if($this->commercial_id == $commercial->id) bg-theme-25 @endif pr-4 pl-2 dark:bg-dark-1 font-medium cursor-pointer">
                 <span
                     x-on:click="selected !== {{ $commercial->id }} ? selected = {{ $commercial->id }} : selected = null"
                     x-show="selected == {{ $commercial->id }}">@icon('chevronDown', null, 'mr-2')</span>
                <span
                    x-on:click="selected !== {{ $commercial->id }} ? selected = {{ $commercial->id }} : selected = null"
                    x-show="selected != {{ $commercial->id }}">@icon('chevronRight', null, 'mr-2')</span>
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
                    <livewire:crmautocar::plateau-list-detail :commercialId="$commercial->id" :key="$commercial->id"/>
                </div>
            @endif
        @endforeach
    </div>
</div>
