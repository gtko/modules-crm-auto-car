<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Tags</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-full>
        <livewire:datalistcrm::data-list :title="'Tag'" :type="\Modules\CrmAutoCar\DataLists\TagDataList::class"/>
    </x-basecore::layout.panel-full>
</x-basecore::app-layout>
