<div>
    <x-basecore::loading-replace wire:target="createProFormat()">
        <button wire:click="createProFormat()" title="Valider le devis">
            @icon('checkCircle', null, 'mr-1 mt-1')
        </button>
    </x-basecore::loading-replace>
</div>
