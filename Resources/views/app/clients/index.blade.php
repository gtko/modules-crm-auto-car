<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Clients</x-basecore::breadcrumb-item>
    </x-slot>

    <livewire:datalistcrm::data-list :title="'Clients'" :type="Modules\CrmAutoCar\DataLists\ClientDataList::class"/>

</x-basecore::app-layout>
