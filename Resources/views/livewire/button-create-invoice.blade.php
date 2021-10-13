<div>
    @if($invoice_exist)
        <button wire:click="show()">Voir invoice</button>
    @else
        <button wire:click="create()">Create invoice</button>
    @endif
</div>
