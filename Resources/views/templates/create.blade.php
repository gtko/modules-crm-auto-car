<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb-item :href="route('templates.index')">Templates</x-breadcrumb-item>
        <x-breadcrumb-item>Ajouter un template</x-breadcrumb-item>
    </x-slot>
    <x-layout.panel-left>
        <x-partials.card>
            <x-slot name="title">
                <a href="{{ route('templates.index') }}" class="mr-4"
                ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
            </x-slot>

            <x-form
                method="POST"
                action="{{ route('templates.store') }}"
            >
                @include('app.templates.form')
                <div class="mt-5 px-2 flex justify-between">
                    <div>
                    </div>
                    <x-button type="submit">
                        <i class="mr-1 icon ion-md-save"></i>
                        @lang('crud.common.create')
                    </x-button>
                </div>
            </x-form>

        </x-partials.card>
    </x-layout.panel-left>
</x-app-layout>
