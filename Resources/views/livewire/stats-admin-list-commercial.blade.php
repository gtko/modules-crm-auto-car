<div class="intro-y box bg-theme-1 p-5 mt-6">
    <div class="pt-3 text-white">
        @foreach($this->commercials as $commercial)
        <span
           class="flex items-center px-3 py-2 rounded-md @if($this->selected && $this->commercial_id == $commercial->id) bg-theme-25 @endif dark:bg-dark-1 font-medium cursor-pointer"
           wire:click="selectCommercial({{$commercial->id}})"
        >
            @icon('user', 18, 'mr-2')
            <span class="pt-1">{{ $commercial->formatName }}</span>

        </span>
        @endforeach
    </div>
</div>

