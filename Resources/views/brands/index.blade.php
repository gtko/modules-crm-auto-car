<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Marques</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>
        <livewire:datalistcrm::data-list :title="'Marques'" :type="\Modules\CrmAutoCar\DataLists\BrandDataList::class"/>
    </x-basecore::layout.panel-full>
</x-basecore::app-layout>
