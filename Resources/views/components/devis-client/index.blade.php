@extends('basecore::layout.main')

@section('content')

    <!-- Start of  Zendesk Widget script -->
    <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=225d297d-d1ea-4ff3-ab9b-f2d399d53e50"> </script>
    <!-- End of  Zendesk Widget script -->

    <style>
        @page {
            size: 1400px 1980px !important;
            /* this affects the margin in the printer settings */
            margin: 0px 0px 0px 0px;
        }

        @media print {

            html, body{
                background: white!important;
            }

            .print-col-span-3 {
                grid-column: span 3 / span 3 !important;
            }

            .notcut {
                position: relative;
                break-inside: avoid;
                page-break-inside: avoid;
                -webkit-region-break-inside: avoid;
            }


            body, .invoice-content {
                position: relative;
                max-width: 100% !important;
                width: 100% !important;
                margin: 0;
            }

            .container, .row {
                padding: 0px;
                width: 100% !important;
                max-width: 100% !important;
            }

            .no-print {
                display: none;
            }

            .footer{
                background: white;
                color: gray;
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
    <div class="bg-gray-200 h-full w-full  flex flex-col justify-between" style="font-family: 'Lato', sans-serif;">
        <div>
            <x-crmautocar::devis-client.header class="shadow py-4 px-4 bg-white"/>
            <div
                class="bg-gray-200 lg:px-12 pt-4 pb-5 max-w-7xl mx-auto sm:px-6 lg:px-8 px-4 lg:grid lg:grid-cols-3 lg:gap-4 ">
                <div class="print-col-span-3 flex-col flex lg:col-span-2">
                    <x-crmautocar::devis-client.voyage-recap :devis="$devis" :brand="$brand"
                                                             class="my-6 pb-4 bg-white border border-gray-400"/>

                    @foreach(($devis->data['trajets'] ?? []) as $idTrajet => $trajet)
                        <div class="my-6 pb-4 bg-white border border-gray-400 notcut">
                            <livewire:crmautocar::devis-client.voyage :devis="$devis" :trajet-id="$idTrajet"
                                                                      :brand="$brand"/>
                        </div>
                    @endforeach

                    @if(($devis->data['nombre_bus'] ?? '') || ($devis->data['nombre_chauffeur'] ?? ''))
                        <div class="bg-white mb-4 p-4 grid notcut justify-items-stretch border border-gray-400">
                            <div class="mb-4">
                                <h5 class="text-bleu my-2 pl-2 font-bold text-xl">Informations complémentaires</h5>
                                <hr class="text-bleu">
                            </div>
                            @if(($devis->data['nombre_bus'] ?? ''))
                            <div>
                                <span>Nombre d'autocar(s) : </span>
                                <span class="font-bold">{{ $devis->data['nombre_bus'] ?? ''}}</span>
                            </div>
                            @endif

                            @if(($devis->data['nombre_chauffeur'] ?? ''))
                            <div>
                                <span>Nombre de conducteur(s) : </span>
                                <span class="font-bold">{{ $devis->data['nombre_chauffeur'] ?? ''}}</span>
                            </div>
                            @endif

                        </div>
                    @endif

                    @if(count(($devis->data['trajets']) ?? []) < 2 || count(($devis->data['lines'] ?? [])) > 0)
                        <livewire:crmautocar::devis-client.recap-devis
                            :devis="$devis"
                            :brand="$brand"
                            :class="'bg-white p-4 grid notcut justify-items-stretch border border-2 border-gray-400'"
                        />
                    @endif
                    <x-crmautocar::devis-client.cgv
                        class="bg-white border border-2 border-gray-400  lg:mb-6 mb-0 mt-6 p-4 lg:order-5 no-print"/>
                </div>
                <div class="col-span-1 print-col-span-3 flex flex-col">
                    <x-crmautocar::devis-client.client-information
                        :devis="$devis"
                        class="my-6 lg:order-1  no-print"
                    />

                    <x-crmautocar::devis-client.conseiller
                        :devis="$devis"
                        class="bg-white border border-2 border-gray-400 p-4 lg:order-3 mb-6  no-print"
                    />

                    <livewire:crmautocar::devis-client.recap-devis
                        :devis="$devis"
                        :brand="$brand"
                        :class="'bg-white p-4 grid justify-items-stretch border border-2 border-gray-400 lg:order-2 mb-4'"
                        :printable="true"
                        :sidebar="true"/>
                </div>
            </div>
        </div>
        <x-crmautocar::devis-client.footer class="footer h-32"/>
    </div>

@endsection
