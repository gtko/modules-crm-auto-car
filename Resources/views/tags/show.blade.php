<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('tags.index')">Tags</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>{{$tag->label}}</x-basecore::breadcrumb-item>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.statuses.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-basecore::partials.card>
                <x-slot name="title">
                    <a href="{{ route('tags.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.statuses.inputs.label')
                        </h5>
                        <span>{{ $tag->label ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.statuses.inputs.weight')
                        </h5>
                        <span>{{ $tag->weight ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('tags.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('basecore::crud.common.back')
                    </a>

                    @can('create', \Modules\CrmAutoCar\Models\Tag::class)
                    <a href="{{ route('tags.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('basecore::crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-basecore::partials.card>
        </div>
    </div>
</x-basecore::app-layout>
