<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Cuves</x-basecore::breadcrumb-item>
    </x-slot>


    <div class="grid grid-cols-12 gap-6 mt-8">

        <livewire:crmautocar::invoices-list/>

    </div>

</x-basecore::app-layout>
