<div class="intro-y box bg-theme-1 p-5 mt-6">
    <div class="pt-3 text-white" x-data="{selected:null}">
        @foreach($this->commercials as $commercial)
            <span class="flex items-center py-2 rounded-md @if($selectedCommercial && $this->commercial_id == $commercial->id) bg-theme-25 @endif dark:bg-dark-1 font-medium cursor-pointer">
                 <span @click="selected !== {{ $commercial->id }} ? selected = {{ $commercial->id }} : selected = null"
                  x-show="selected == {{ $commercial->id }}">@icon('chevronDown', null, 'mr-2')</span>
                <span @click="selected !== {{ $commercial->id }} ? selected = {{ $commercial->id }} : selected = null"
                  x-show="selected != {{ $commercial->id }}">@icon('chevronRight', null, 'mr-2')</span>
                <span class="flex justify-between w-full items-center">
                    <span class="pt-1" wire:click="selectCommercial({{$commercial->id}})">{{ $commercial->formatName }}</span>
                    @if ($commercial->isActif)
                        <div class="w-2 h-2 bg-green-600 rounded-full"></div>
                    @else
                        <div class="w-2 h-2 bg-red-600 rounded-full"></div>
                    @endif
                </span>
            </span>
            <div x-show="selected == {{ $commercial->id }}">
                <livewire:crmautocar::plateau-list-detail :commercialId="$commercial->id" wire:key="$commercial->id"/>
            </div>
        @endforeach
    </div>
</div>

