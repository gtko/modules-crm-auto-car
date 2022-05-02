<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Fournisseurs</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>
        <h2 class="text-lg font-medium mt-10">Fournisseurs Centrale Autocar</h2>
        <div class="flex flex-wrap justify-between sm:flex-nowrap items-center mt-2">
            <a href="{{route('fournisseurs.create')}}" class="btn btn-primary shadow-md mr-2">
                @icon('addCircle', null, 'mr-2') Ajouter un fournisseur
            </a>
        </div>

        <livewire:crmautocar::list-fournisseurs />

    </x-basecore::layout.panel-full>

</x-basecore::app-layout>
