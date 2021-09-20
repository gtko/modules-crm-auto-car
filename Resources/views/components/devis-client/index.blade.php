@extends('basecore::layout.main')

@section('content')

{{--    <livewire:crmautocar::devis-client.popup-valition/>--}}
    <div class="bg-white h-full w-full" style="font-family: 'Lato', sans-serif;">

        <x-crmautocar::devis-client.header class="shadow py-4 px-4" />

        <div class="bg-gray-200 lg:px-12 pt-4 max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 lg:grid lg:grid-cols-3 lg:gap-4 ">
            <div class="flex-col flex lg:col-span-2">
{{--                <x-crmautocar::devis-client.voyage-recap :devis="$devis" class="my-6 pb-4 bg-white" />--}}

{{--                <livewire:crmautocar::devis-client.recap-devis--}}
{{--                    :devis="$devis"--}}
{{--                    :class="'bg-white p-4 grid justify-items-stretch border border-2 border-gray-400'"--}}
{{--                />--}}

{{--                <x-crmautocar::devis-client.cgv class="bg-white border border-2 border-gray-400  lg:mb-6 mb-0 mt-6 p-4 lg:order-5"/>--}}
            </div>
            <div class="col-span-1 flex flex-col">
{{--                <x-crmautocar::devis-client.client-information--}}
{{--                    :devis="$devis"--}}
{{--                    class="my-6 lg:order-1"--}}
{{--                />--}}

{{--                <x-crmautocar::devis-client.conseiller--}}
{{--                    :devis="$devis"--}}
{{--                    class="bg-white border border-2 border-gray-400 p-4 lg:order-3 mb-6"--}}
{{--                />--}}

{{--                <livewire:crmautocar::devis-client.recap-devis--}}
{{--                    :devis="$devis"--}}
{{--                    :class="'bg-white p-4 grid justify-items-stretch border border-2 border-gray-400 lg:order-2 mb-4'"--}}
{{--                    :sidebar="true"/>--}}
            </div>
        </div>
{{--        <x-crmautocar::devis-client.footer class="h-32"/>--}}
    </div>

@endsection
