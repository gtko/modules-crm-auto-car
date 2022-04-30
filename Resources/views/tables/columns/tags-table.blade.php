<div class="text-center space-y-1" x-data="{open: false}">
    @foreach($getState() as $index => $tag)
        @if ($index < 2)
            <div style="background-color:{{$tag->color}}"
                 class="py-1 px-2 rounded text-xs text-white font-medium whitespace-nowrap">
                {{$tag->label}}
            </div>
        @else

            <div style="background-color:{{$tag->color}}" x-show="open"
                 class="py-1 px-2 rounded text-xs text-white font-medium whitespace-nowrap">
                {{$tag->label}}
            </div>
        @endif

        @if($index == 2)
            <div class="flex justify-center text-xs text-white rounded bg-green-400">
                    <span @click.stop="open = true"
                          x-show="!open">Voir {{$getState()->count() - 2}} de plus ...</span>
            </div>
        @elseif($index == $getState()->count() - 1 )
            <div class="flex justify-center text-xs text-white rounded bg-green-400">
                <span @click.stop="open = false" x-show="open">Voir moins ...</span>
            </div>
        @endif

    @endforeach
</div>
