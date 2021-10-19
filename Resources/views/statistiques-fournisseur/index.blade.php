<x-basecore::app-layout>

    @push('modals')
        <livewire:basecore::modal
            name="popup-detail-paiement"
            :type="Modules\BaseCore\Entities\TypeView::TYPE_LIVEWIRE"
            path='crmautocar::statistique-fournisseur-popup-detail'
        />

    @endpush

    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Statistiques fournisseur</x-basecore::breadcrumb-item>
    </x-slot>


    <div>

        <livewire:crmautocar::statistique-fournisseur-card/>

        <livewire:crmautocar::statistique-fournisseur-filtre/>

        <livewire:crmautocar::statistique-fournisseur-list/>
    </div>
</x-basecore::app-layout>
