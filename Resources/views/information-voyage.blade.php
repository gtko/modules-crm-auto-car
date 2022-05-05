@extends('basecore::layout.main')

@section('content')

    <style>

        html, body {
            background: #f8f8f8;
            font-family: 'Lato', sans-serif;
        }

        @page {
            size: 1400px 2040px !important;
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

    <div class="flex flex-col">
        @foreach(($devis->data['trajets'] ?? []) as $trajet)

            <div class="h-full w-full h-screen flex flex-col justify-between">
            <div class="max-w-7xl w-full mx-auto pt-16 px-8 pb-16">
                <div class="grid grid-cols-6 items-center mb-10">
                    <div class="flex justify-center col-span-2">
                        <div>
                            <img src="{{asset('/assets/img/logo-centrale-autocar.png')}}" alt="" class="h-auto w-full">
                        </div>
                    </div>
                    <div class="col-span-2"></div>
                    <div class="col-span-2">
                        <img src="{{asset('/assets/img/autocar.jpg')}}" alt="" class="w-full">
                    </div>
                </div>

                        <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
                            <div class="text-center">
                                <h2 class="text-base font-semibold text-bleu tracking-wide uppercase">{{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'])->translatedFormat('l d F Y') ?? ''}}</h2>
                                @if(($trajet['aller_point_depart'] ?? false) && !($trajet['retour_point_depart'] ?? false))
                                    <p class="mt-1 text-2xl font-extrabold text-gray-900 sm:text-3xl sm:tracking-tight lg:text-4xl">
                                        Transfert Aller.
                                    </p>
                                @endif

                                @if(!($trajet['aller_point_depart'] ?? false) && ($trajet['retour_point_depart'] ?? false))
                                    <p class="mt-1 text-2xl font-extrabold text-gray-900 sm:text-3xl sm:tracking-tight lg:text-4xl">
                                        Transfert Retour.
                                    </p>
                                @endif

                                @if(($trajet['aller_point_depart'] ?? false) && ($trajet['retour_point_depart'] ?? false))
                                    <p class="mt-1 text-2xl font-extrabold text-gray-900 sm:text-3xl sm:tracking-tight lg:text-4xl">
                                        Transfert Aller/Retour.
                                    </p>
                                @endif
                                <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500"> {{ $trajet['aller_pax'] ?? ''}} passagers à l'aller / {{ $trajet['retour_pax'] ?? ''}} passagers au retour</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white shadow overflow-hidden sm:rounded-lg
                                @if(!$trajet['retour_date_depart']) col-span-2 @endif
                                ">
                                <div class="px-4 py-5 sm:px-6">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">Transfert aller</h3>
                                    <p class="mt-1 max-w-2xl text-sm text-gray-500">Tous les détails de votre transfert aller</p>
                                </div>
                                <div class="border-t border-gray-200">
                                    <dl>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Date de départ</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'])->format('d/m/Y') ?? ''}}
                                            </dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Heure de départ</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'])->format('h:i:s') ?? ''}}
                                            </dd>
                                        </div>
                                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Lieu de départ</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{ $trajet['addresse_ramassage'] ??  $trajet['aller_distance']['origin_formatted'] ?? ''}}
                                            </dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Lieu de destination</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{  $trajet['addresse_destination'] ??   $trajet['retour_distance']['origin_formatted'] ?? ''}}
                                            </dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Contact sur place</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{  $trajet['contact_nom'] ?? ''}}  {{  $trajet['contact_prenom'] ?? ''}}
                                            </dd>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                            <dt class="text-sm font-medium text-gray-500">Contact Téléphone</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                {{  $trajet['tel_1'] ?? ''}} <br>
                                                {{  $trajet['tel_2'] ?? ''}}
                                            </dd>
                                        </div>
                                    </dl>
                                </div>
                            </div>
                            @if($trajet['retour_date_depart'])
                                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                                    <div class="px-4 py-5 sm:px-6">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">Transfert retour</h3>
                                        <p class="mt-1 max-w-2xl text-sm text-gray-500">Tous les détails de votre transfert retour</p>
                                    </div>
                                    <div class="border-t border-gray-200">
                                        <dl>
                                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">Date de départ</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'])->format('d/m/Y') ?? ''}}
                                                </dd>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">Heure de départ</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'])->format('h:i:s') ?? ''}}
                                                </dd>
                                            </div>
                                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">Lieu de départ</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ $trajet['addresse_ramassage_retour'] ??  $trajet['retour_distance']['origin_formatted'] ?? ''}}
                                                </dd>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">Lieu de destination</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{ $trajet['addresse_destination_retour'] ??   $trajet['retour_point_arriver'] ?? ''}}
                                                </dd>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">Contact sur place</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{  $trajet['contact_nom'] ?? ''}}  {{  $trajet['contact_prenom'] ?? ''}}
                                                </dd>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                <dt class="text-sm font-medium text-gray-500">Contact Téléphone</dt>
                                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                    {{  $trajet['tel_1'] ?? ''}} <br>
                                                    {{  $trajet['tel_2'] ?? ''}}
                                                </dd>
                                            </div>
                                        </dl>
                                    </div>
                                </div>
                            @endif
                    </div>


                        <div class="grid grid-cols-2 gap-8">
                            <div class="mt-8">
                                <div class="flex items-center">
                                    <h4 class="flex-shrink-0 pr-4 text-sm tracking-wider font-semibold uppercase text-bleu">
                                       Commentaires
                                    </h4>
                                    <div class="flex-1 border-t-2 border-gray-200"></div>
                                </div>
                                <p class="mt-8 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-5">
                                    {{ $trajet['commentaire'] ?? 'Aucun commentaire'}}
                                </p>
                            </div>
                            <div class="mt-8">
                                <div class="flex items-center">
                                    <h4 class="flex-shrink-0 pr-4 text-sm tracking-wider font-semibold uppercase text-bleu">
                                        Informations complémentaires
                                    </h4>
                                    <div class="flex-1 border-t-2 border-gray-200"></div>
                                </div>
                                <p class="mt-8 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-5">
                                    {!! $trajet['information_complementaire'] ?? 'Aucune information complémentaire' !!}
                                </p>
                            </div>
                        </div>

                <div class="text-center text-2xl mt-12">
                    Centrale Autocar
                </div>
                <div class="text-center mt-2">
                    Société par Actions Simplifiées - N° Siret : 853 867 703 00011 - R.C.S. Paris 853 867 703 - Code APE : 4939B
                </div>
                @php($trajet = null)
            </div>
    </div>
        @endforeach
@endsection
