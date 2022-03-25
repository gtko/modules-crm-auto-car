@extends('basecore::layout.main')

@section('content')

    <style>

        html, body {
            background: #f8f8f8;
            font-family: 'Lato', sans-serif;
        }

        @page {
            size: 1400px 2080px !important;
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







        @foreach(($devis->data['trajets'] ?? []) as $index => $trajet)

            <!-- This example requires Tailwind CSS v2.0+ -->
                <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-base font-semibold text-bleu tracking-wide uppercase">{{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'])->translatedFormat('l d F Y') ?? ''}}</h2>
                        <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                            Transfert vers {{ $trajet['aller_point_arriver'] ?? ''}}
                        </p>
                        <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500"> {{ $trajet['aller_pax'] ?? ''}} passagers à l'aller / {{ $trajet['retour_pax'] ?? ''}} passagers au retour</p>
                    </div>
                </div>


                    @if($index != 0)
                        <div class="text-xl font-extrabold underline mb-2">Voyage n°{{$index + 1}}</div>
                    @endif

{{--                    <div class="text-xl font-bold underline mt-4">Contact chauffeur retour :</div>--}}
{{--                    <span class="text-lg"> <br>--}}
{{--                        {{ $devis->data['retour_tel_chauffeur'] ?? '' }}--}}

{{--                    </span>--}}


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
                                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                            <dt class="text-sm font-medium text-gray-500">Contact chauffeur</dt>
                                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                                {{ $devis->data['aller_tel_chauffeur'] ?? '' }}
                                                            </dd>
                                                        </div>
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
                                                                {{ $trajet['aller_distance']['origin_formatted'] ?? ''}}
                                                            </dd>
                                                        </div>
                                                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                                            <dt class="text-sm font-medium text-gray-500">Lieu de destination</dt>
                                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                                {{ $trajet['retour_distance']['origin_formatted'] ?? ''}}
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
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Contact chauffeur</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $devis->data['retour_tel_chauffeur'] ?? '' }}
                                    </dd>
                                </div>
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
                                        {{ $trajet['retour_distance']['origin_formatted'] ?? ''}}
                                    </dd>
                                </div>
                                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Lieu de destination</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                        {{ $trajet['retour_point_arriver'] ?? ''}}
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
                                    Ce prix comprend
                                </h4>
                                <div class="flex-1 border-t-2 border-gray-200"></div>
                            </div>
                            <ul role="list" class="mt-8 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-5">

                                @if (($trajet['inclus_repas_chauffeur'] ?? null) === true)
                                    <li class="flex items-start lg:col-span-1">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-green-400" x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">
                                            Repas chauffeur
                                        </p>
                                    </li>
                                @endif
                                @if (($trajet['inclus_hebergement']?? null) === true)
                                        <li class="flex items-start lg:col-span-1">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-green-400" x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <p class="ml-3 text-sm text-gray-700">
                                                Hébergement
                                            </p>
                                        </li>
                                @endif
                                @if (($trajet['inclus_parking'] ?? null) === true)
                                        <li class="flex items-start lg:col-span-1">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-green-400" x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <p class="ml-3 text-sm text-gray-700">
                                                Parking
                                            </p>
                                        </li>
                                @endif
                                @if (($trajet['inclus_peages'] ?? null) === true)
                                        <li class="flex items-start lg:col-span-1">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-green-400" x-description="Heroicon name: solid/check-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <p class="ml-3 text-sm text-gray-700">
                                                Péages
                                            </p>
                                        </li>
                                @endif
                            </ul>
                        </div>
                        <div class="mt-8">
                            <div class="flex items-center">
                                <h4 class="flex-shrink-0 pr-4 text-sm tracking-wider font-semibold uppercase text-bleu">
                                    Ce prix ne comprend pas
                                </h4>
                                <div class="flex-1 border-t-2 border-gray-200"></div>
                            </div>
                            <ul role="list" class="mt-8 space-y-5 lg:space-y-0 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-5">

                                @if (($trajet['inclus_repas_chauffeur'] ?? null) === false)
                                    <li class="flex items-start lg:col-span-1">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">
                                            Repas chauffeur
                                        </p>
                                    </li>
                                @endif
                                @if (($trajet['inclus_hebergement'] ?? null) === false)
                                    <li class="flex items-start lg:col-span-1">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">
                                            Hébergement
                                        </p>
                                    </li>
                                @endif
                                @if (($trajet['inclus_parking'] ?? null) === false)
                                    <li class="flex items-start lg:col-span-1">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">
                                            Parking
                                        </p>
                                    </li>
                                @endif
                                @if (($trajet['inclus_peages'] ?? null) === false)
                                    <li class="flex items-start lg:col-span-1">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">
                                            Péages
                                        </p>
                                    </li>
                                @endif

                                    <li class="flex items-start lg:col-span-2">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">
                                            Les éventuels kilométres supplémentaires (1.10€ TTC/kilométre) si modification de programme
                                        </p>
                                    </li>

                                    <li class="flex items-start lg:col-span-2">
                                        <div class="flex-shrink-0">
                                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                                        </div>
                                        <p class="ml-3 text-sm text-gray-700">
                                            Les éventuels heures supplémentaires (25€ TTC/heure) si modification de programme
                                        </p>
                                    </li>
                            </ul>
                        </div>
                    </div>
                    @endforeach


                    <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8">
                                <div class="max-w-3xl mx-auto text-center">
                                    <h2 class="text-3xl font-extrabold text-gray-900">Rappel de la législation</h2>
                                    <p class="mt-4 text-lg text-gray-500">Le port du masque est obligatoire sur toute la durée du transfert.</p>
                                </div>
                                <dl class="mt-12 space-y-10 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 lg:grid-cols-4 lg:gap-x-8">
                                    <div class="relative">
                                        <dt>
                                            <!-- Heroicon name: outline/check -->
                                            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Amplitude</p>
                                        </dt>
                                        <dd class="mt-2 ml-9 text-base text-gray-500">12h pour un conducteur et 18h pour deux conducteurs en double équipage</dd>
                                    </div>

                                    <div class="relative">
                                        <dt>
                                            <!-- Heroicon name: outline/check -->
                                            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Temps de conduite</p>
                                        </dt>
                                        <dd class="mt-2 ml-9 text-base text-gray-500">9h de conduite pour un conducteur par jour.</dd>
                                    </div>

                                    <div class="relative">
                                        <dt>
                                            <!-- Heroicon name: outline/check -->
                                            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">Coupure</p>
                                        </dt>
                                        <dd class="mt-2 ml-9 text-base text-gray-500">une coupure de 45 min toutes les 4h30 de conduite.<br>
                                            De 21h à 06h (heures de nuit) les coupures ont lieu toutes les 4h de conduite.</dd>
                                    </div>

                                    <div class="relative">
                                        <dt>
                                            <!-- Heroicon name: outline/check -->
                                            <svg class="absolute h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            <p class="ml-9 text-lg leading-6 font-medium text-gray-900">repos</p>
                                        </dt>
                                        <dd class="mt-2 ml-9 text-base text-gray-500">1 jour de repos obligatoire sur place pour les voyage de plus de 6 jours.</dd>
                                    </div>
                                </dl>
                            </div>


                    <div class="max-w-7xl text-center">
                        <h1 class="text-sm font-semibold uppercase tracking-wide text-bleu">Merci !</h1>
                        <p class="mt-2 text-2xl font-extrabold tracking-tight sm:text-3xl">L'équipe de Centrale AutoCar vous souhaites un excellent voyage</p>
                        <p class="mt-2 text-base text-red-500">En cas d'urgence contacter le 06 18 37 37 70. <br> Réf du voyage <span class="font-bold">#{{$devis->ref}}</span></p>


                    </div>

                    <div class="text-center text-2xl mt-12">
                        Centrale Autocar
                    </div>
                    <div class="text-center mt-2">
                        Société par Actions Simplifiées - N° Siret : 853 867 703 00011 - R.C.S. Paris 853 867 703 - Code APE : 4939B
                    </div>
        </div>
    </div>

@endsection
