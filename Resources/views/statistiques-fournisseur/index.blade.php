<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Statistiques fournisseur</x-basecore::breadcrumb-item>
    </x-slot>


    <div>
        <livewire:crmautocar::statistique-fournisseur-filtre/>

        <livewire:crmautocar::statistique-fournisseur-list/>
    </div>
</x-basecore::app-layout>
