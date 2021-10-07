<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('templates.index')">Templates</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Editer le template</x-basecore::breadcrumb-item>
    </x-slot>
    <x-basecore::layout.panel-left>
        <x-basecore::partials.card>
            <x-slot name="title">
                <a href="{{ route('templates.index') }}" class="mr-4"
                ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
            </x-slot>

            <x-basecore::form
                method="PUT"
                action="{{ route('templates.update', $template) }}"
            >
                @include('crmautocar::templates.form')
                <div class="mt-5 px-2 flex justify-between">
                    <div>
                    </div>
                    <x-basecore::button type="submit">
                        <i class="mr-1 icon ion-md-save"></i>
                        @lang('crud.common.update')
                    </x-basecore::button>
                </div>
            </x-basecore::form>

        </x-basecore::partials.card>
    </x-basecore::layout.panel-left>
</x-basecore::app-layout>
