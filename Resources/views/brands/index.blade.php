<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb-item>Marques</x-breadcrumb-item>
    </x-slot>
    <x-layout.panel-full>
        <x-data-list :title="'Marques'" :datas="$brands" :type="new App\DataListTypes\BrandDataList()"/>
    </x-layout.panel-full>
</x-app-layout>
