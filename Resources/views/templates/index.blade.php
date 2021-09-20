<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb-item>Templates</x-breadcrumb-item>
    </x-slot>
    <livewire:data-list :title="'Templates'" :type="App\DataListTypes\TemplateDataList::class"/>
</x-app-layout>
