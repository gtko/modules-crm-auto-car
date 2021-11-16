@extends('basecore::layout.main')

@section('content')

    <style>
        @page {
            size: 1400px 1980px!important;
            /* this affects the margin in the printer settings */
            margin: 0px 0px 0px 0px;
        }
        @media print {
            body, .invoice-content {
                position:relative;
                max-width:100%!important;
                width:100% !important;
                margin:0;
            }
            .container, .row {
                padding: 0px;
                width: 100%!important;
                max-width: 100%!important;
            }

            .no-print{
                display:none;
            }

        }
    </style>

    @push('modals')
        <livewire:basecore::modal
            name="popup-valition"
            :type="Modules\BaseCore\Entities\TypeView::TYPE_LIVEWIRE"
            path='crmautocar::devis-client.popup-valition'
            :arguments="['devis' => $devis]"
        />

    @endpush
    <div class="bg-white h-full w-full h-screen flex flex-col justify-between" style="font-family: 'Lato', sans-serif;">
        <div>
            <x-crmautocar::devis-client.header class="shadow py-4 px-4"/>
            <div
                class="bg-gray-200 lg:px-12 pt-4 pb-5 max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 lg:grid lg:grid-cols-3 lg:gap-4 ">
                <div class="flex-col flex lg:col-span-2">
                    <x-crmautocar::devis-client.voyage-recap :devis="$devis" :brand="$brand" class="my-6 pb-4 bg-white"/>

                    <livewire:crmautocar::devis-client.recap-devis
                        :devis="$devis"
                        :brand="$brand"
                        :class="'bg-white p-4 grid justify-items-stretch border border-2 border-gray-400'"
                    />

                    <x-crmautocar::devis-client.cgv
                        class="bg-white border border-2 border-gray-400  lg:mb-6 mb-0 mt-6 p-4 lg:order-5 no-print"/>
                </div>
                <div class="col-span-1 flex flex-col">
                    <x-crmautocar::devis-client.client-information
                        :devis="$devis"
                        class="my-6 lg:order-1"
                    />

                    <x-crmautocar::devis-client.conseiller
                        :devis="$devis"
                        class="bg-white border border-2 border-gray-400 p-4 lg:order-3 mb-6"
                    />

                    <livewire:crmautocar::devis-client.recap-devis
                        :devis="$devis"
                        :brand="$brand"
                        :class="'bg-white p-4 grid justify-items-stretch border border-2 border-gray-400 lg:order-2 mb-4'"
                        :sidebar="true"/>
                </div>
            </div>
        </div>
        <x-crmautocar::devis-client.footer class="h-32"/>
    </div>

@endsection
