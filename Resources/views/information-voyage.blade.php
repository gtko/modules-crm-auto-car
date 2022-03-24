@extends('basecore::layout.main')

@section('content')

    <style>

        html, body {
            background: white;
        }

        @page {
            size: 1400px 1980px !important;
            /* this affects the margin in the printer settings */
            margin: 0px 0px 0px 0px;
        }

        @media print {

            .print-col-span-3 {
                grid-column: span 3 / span 3 !important;
            }

            .notcut {
                position: relative;
                break-inside: avoid;
                page-break-inside: avoid;
                -webkit-region-break-inside: avoid;
            }

            .bg-gray-200 {
                background: white;
            }

            .newpage {
                page-break-before: always;
            }

            .margintopprint {
                margin-top: 80px;
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

        }
    </style>
    {{--        @dd($devis->data)--}}
    <div class="bg-white h-full w-full h-screen flex flex-col justify-between" style="font-family: 'Lato', sans-serif;">
        <div class="max-w-7xl w-full mx-auto pt-16 px-8 pb-16">
            <div class="text-red-600 text-4xl font-extrabold text-center underline">Dossier conducteur</div>
            {{--                                    @dd($devis->data)--}}
            @foreach(($devis->data['trajets'] ?? []) as $index => $trajet)
                <div class="mb-8">

                    @if($index != 0)
                        <div class="text-xl font-extrabold underline mb-2">Voyage n°{{$index + 1}}</div>
                    @endif

                    <div
                        class="text-4xl font-bold text-blue-400 text-center mt-4">{{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'])->translatedFormat('l d F Y') ?? ''}}</div>
                    <div class="text-4xl font-bold text-blue-400 text-center mt-4">
                        Transfert vers {{ $trajet['aller_point_arriver'] ?? ''}}
                    </div>
                    <div class="text-2xl font-bold text-center mt-4">
                        {{ $trajet['aller_pax'] ?? ''}} pax à l'aller / {{ $trajet['retour_pax'] ?? ''}} pax au retour
                    </div>


                    <div class="font-bold space-y-2 mt-6">
                        <div>Date de
                            départ: {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'])->format('d/m/Y') ?? ''}}</div>
                        <div>Heure de
                            départ: {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'])->format('h:i:s') ?? ''}}</div>
                        <div>Lieu de départ: {{ $trajet['aller_distance']['origin_formatted'] ?? ''}}</div>
                        <div>Lieu de destination: {{ $trajet['retour_distance']['origin_formatted'] ?? ''}}</div>
                        <div>Contact Chauffeur:
                            <span> <br> -Aller {{ $devis->data['aller_tel_chauffeur'] ?? '' }}</span>
                            <span> <br> -Retour {{ $devis->data['retour_tel_chauffeur'] ?? '' }}</span>
                        </div>
                    </div>
                    <div>
                        <div class="text-blue-600 py-4">Ce prix comprend</div>
                        <div class="flex flex-col">
                            @if ($trajet['inclus_repas_chauffeur'])
                                <span>-Repas chauffeur</span>
                            @endif
                            @if ($trajet['inclus_hebergement'])
                                <span>-Hébergement</span>
                            @endif
                            @if ($trajet['inclus_parking'])
                                <span>-Parking</span>
                            @endif
                            @if ($trajet['inclus_peages'])
                                <span>-Péages</span>
                            @endif
                        </div>
                        <div class="text-blue-600 py-4">Ce prix ne comprend pas</div>
                        <div class="flex flex-col">
                            @if (!$trajet['inclus_repas_chauffeur'])
                                <span>-Repas chauffeur</span>
                            @endif
                            @if (!$trajet['inclus_hebergement'])
                                <span>-Hébergement</span>
                            @endif
                            @if (!$trajet['inclus_parking'])
                                <span>-Parking</span>
                            @endif
                            @if (!$trajet['inclus_peages'])
                                <span>-Péages</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="space-y-4 font-extrabold text-xs">
                <div class="uppercase"> Rappel de la legislation</div>
                <div class="uppercase underline">port du masque obligatoire toute la duree du transfert</div>
                <div>-Amplitude: 12h pour un conducteur et 18h pour deux conducteurs en double équipage</div>
                <div>-Temps de conduite: 9h de conduite pour un conducteur par jour.</div>
                <div>-Coupure: une coupure de 45 min toutes les 4h30 de conduite.</div>
                <div>-De 21h à 06h (heures de nuit) les coupures ont lieu toutes les 4h de conduite.</div>
                <div>-repos: 1 jour de repos obligatoire sur place pour les voyage de plus de 6 jours</div>
                <div>Attention il est impératif en cas de contrôle routier d'avoir la liste des participants à bord de
                    l'autocar
                </div>
            </div>
            <div class="text-lg text-red-600 flex flex-col justify-center items-center mt-8 space-y-6 font-bold">
                <div>Nous vous souhaitons un excellent voyage</div>
                <div>Contact d'urgence 06 18 37 37 70</div>
            </div>
        </div>

    @dump($trajet)

@endsection
