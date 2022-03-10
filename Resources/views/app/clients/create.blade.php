<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item :href="route('dossiers.index')">Clients</x-basecore::breadcrumb-item>
        <x-basecore::breadcrumb-item>Ajouter un client</x-basecore::breadcrumb-item>
    </x-slot>

    <x-basecore::layout.panel-left>
        <x-basecore::partials.card>
                <x-slot name="title">
                    <a href="{{ route('clients.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <x-basecore::form
                    method="POST"
                    action="{{ route('clients.store') }}"
                    class="mt-4"
                >
                    <x-crmautocar::client.client-form>
                            <a href="{{ route('clients.index') }}" class="button">
                                <i
                                    class="
                                        mr-1
                                        icon
                                        ion-md-return-left
                                        text-primary
                                    "
                                ></i>
                                @lang('basecore::crud.common.back')
                            </a>
                    </x-crmautocar::client.client-form>
                </x-basecore::form>
            </x-basecore::partials.card>
    </x-basecore::layout.panel-left>
</x-basecore::app-layout>
