<x-basecore::app-layout>

{{--    @section('content-modifier')--}}
{{--        content--dashboard--}}
{{--    @endsection--}}

    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Factures</x-basecore::breadcrumb-item>
    </x-slot>



    <livewire:crmautocar::invoices-list/>


</x-basecore::app-layout>
