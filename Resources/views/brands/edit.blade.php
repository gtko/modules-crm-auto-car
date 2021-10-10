<x-app-layout>
    <x-slot name="breadcrumb">
        <x-breadcrumb-item :href="route('brands.index')">Brands</x-breadcrumb-item>
        <x-breadcrumb-item :href="route('brands.show', $brand)">{{$brand->label}}</x-breadcrumb-item>
        <x-breadcrumb-item>Editer</x-breadcrumb-item>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.brands.edit_title')
        </h2>
    </x-slot>
    <x-layout.panel-left>
        <x-partials.card>
            <x-slot name="title">
                <a href="{{ route('brands.index') }}" class="mr-4"
                ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
            </x-slot>

            <x-form
                method="PUT"
                action="{{ route('brands.update', $brand) }}"
                class="mt-4"
            >
                @include('app.brands.form-inputs')

                <div class="mt-10">
                    <a href="{{ route('brands.index') }}" class="button">
                        <i
                            class="
                                    mr-1
                                    icon
                                    ion-md-return-left
                                    text-primary
                                "
                        ></i>
                        @lang('crud.common.back')
                    </a>

                    <a href="{{ route('brands.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add text-primary"></i>
                        @lang('crud.common.create')
                    </a>

                    <x-button type="submit">
                        <i class="mr-1 icon ion-md-save"></i>
                        @lang('crud.common.update')
                    </x-button>
                </div>
            </x-form>
        </x-partials.card>
    </x-layout.panel-left>
</x-app-layout>
