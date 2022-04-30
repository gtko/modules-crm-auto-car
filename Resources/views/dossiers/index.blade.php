<x-basecore::app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.dossiers.index_title')
        </h2>
    </x-slot>

{{--    <livewire:crmautocar::dossiers.list-client/>--}}

    <livewire:crmautocar::datatable.list-dossier/>

</x-basecore::app-layout>
