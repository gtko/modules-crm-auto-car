<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Templates</x-basecore::breadcrumb-item>
    </x-slot>
    <livewire:datalistcrm::data-list :title="'Templates'" :type="\Modules\CrmAutoCar\DataLists\TemplateDataList::class"/>
</x-basecore::app-layout>
