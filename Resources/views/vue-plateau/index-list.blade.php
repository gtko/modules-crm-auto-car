<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>statistique</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Detail</x-basecore::breadcrumb-item>
    </x-slot>
    <livewire:crmautocar::plateau-list-user-by-status-list :commercialId="$commercial_id" :statusId="$status_id"/>
</x-basecore::app-layout>
