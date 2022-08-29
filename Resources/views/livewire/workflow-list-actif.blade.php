<div>
    <span wire:click.prevent.stop="toggle()">
    @if($workflow->active)
        @icon('stop', null, 'mr-2 text-red-600 cursor-pointer')
    @else
        @icon('play', null, 'mr-2 text-green-600 cursor-pointer')
    @endif
    </span>
</div>

