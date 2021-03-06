<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Statistiques</x-basecore::breadcrumb-item>
    </x-slot>


    <livewire:crmautocar::statistique-v2/>


{{--    @if(Auth::user()->isSuperAdmin() || Auth::user()->hasRole('manager'))--}}
{{--        <livewire:crmautocar::stats-filter-date-global/>--}}
{{--        <livewire:crmautocar::stats-admin-card-global/>--}}
{{--    @endif--}}

{{--    <div class="grid grid-cols-12 gap-6 mt-8">--}}
{{--        <div class="col-span-12 lg:col-span-3 xxl:col-span-2">--}}
{{--            <livewire:crmautocar::stats-admin-list-commercial/>--}}
{{--        </div>--}}
{{--        <div class="col-span-12 lg:col-span-9 xxl:col-span-10">--}}
{{--            @if(!Auth::user()->isSuperAdmin() || Auth::user()->hasRole('manager'))--}}
{{--            <livewire:crmautocar::stats-filter-date/>--}}
{{--            @endif--}}
{{--            <livewire:crmautocar::stats-admin-card/>--}}
{{--            <livewire:crmautocar::stat-admin-client-list/>--}}
{{--        </div>--}}
{{--    </div>--}}

</x-basecore::app-layout>
