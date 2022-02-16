<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('dossiers.index')">Clients</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item
            :href="route('clients.show', $client)">{{$client->format_name}}</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Ajouter un dossier</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-left>
        <x-basecore::partials.card>

            <livewire:crmautocar::dossier-create :client="$client"/>

        </x-basecore::partials.card>
    </x-basecore::layout.panel-left>
</x-basecore::app-layout>
