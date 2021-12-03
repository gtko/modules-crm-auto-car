@extends('basecore::layout.main')

@section('content')

    <style>
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
        <div class="max-w-7xl w-full mx-auto pt-32 bg-gray-200 px-8">

            <div class="grid grid-cols-3 gap-2">
                <div class="col-start-3 flex-col flex">
                    <span class="font-extrabold">{{ $devis->dossier->client->formatName }}</span>
                    <span class="uppercase">{{ $devis->dossier->client->address }}</span>
                    <span
                        class="uppercase">{{ $devis->dossier->client->codeZip }} {{ $devis->dossier->client->city }}</span>
                </div>
            </div>

            <div class="grid-cols-3 grid gap-2">
                <div class="flex flex-col">
                    <span class="mb-4">Devis n° <span class="font-extrabold">{{ $devis->ref }}</span></span>
                    <span>Dossier suivi par: {{ $devis->commercial->formatName }}</span>
                    <span>Tel: {{ $devis->commercial->phone }}</span>
                    <span class="text-sm">Mail : {{ $devis->commercial->email }}</span>
                </div>
                <div class="my-auto col-start-3">
                    <span>Paris, le {{ \Carbon\Carbon::createFromTimeString($devis->created_at ?? '')->translatedFormat('l d F Y') }}</span>
                </div>
            </div>

            <div class="flex flex-col mt-12">
                <span class="mb-4">Bonjour {{ $devis->dossier->client->formatName }}</span>
                <span>Nous avons le plaisir de vous communiquer nos conditions de prix pour votre projet de voyage <span
                        class="text-xs">(Aller et Retour)</span>:</span>

                @foreach(($devis->data['trajets'] ?? []) as $index => $trajet)
                    <div class="flex-col flex justify-center items-center font mx-auto my-6 font-black text-lg">
                        @if(($trajet['aller_distance']['origin_formatted'] ?? false) && ($trajet['aller_date_depart'] ?? false))
                            <span>Voyage n°{{$index + 1}}</span>
                            <span class="font-bold">le {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('l d F Y') }}.</span>
                            <span> {{ $trajet['aller_point_depart'] }}</span>
                        @else
                            <span class="font-bold">Aucune date</span>
                        @endif
                    </div>
                @endforeach


                <span>Afin de vous réserver le véhicule nécessaire, nous vous remercions de nous faire connaître votre décision dès que possible en nous retournant ce devis signé à l’adresse ci-dessus.</span>
                <span class="mt-4 mb-2">Descriptif du Séjour :</span>
            </div>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                <tr>
                                    <th scope="col"
                                        class="px-6 text-left text-xs font-medium uppercase tracking-wider"></th>
                                    <th scope="col"
                                        class="px-6 text-left text-xs font-medium  uppercase tracking-wider  border-black border font-bold"
                                        style="background-color: gray">
                                        Horaire
                                    </th>
                                    <th scope="col"
                                        class="px-6 text-left text-xs font-medium  uppercase tracking-wider  border-black border font-bold"
                                        style="background-color: gray">
                                        Lieu
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach(($devis->data['trajets'] ?? []) as $index => $trajet)
                                    <tr class="bg-white">
                                        <td class="px-6 py-2 whitespace-nowrap text-sm font-medium font-extrabold ">
                                            Voyage n°{{$index + 1}}
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm  text-center">

                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm  font-bold text-center">

                                        </td>
                                    </tr>

                                    <tr class="bg-white">
                                        <td class="px-6 whitespace-nowrap text-sm font-medium border-black border font-bold">
                                            Départ aller
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            le {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
                                            à {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('h:i') }}
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['addresse_ramassage'] }}
                                        </td>
                                    </tr>

                                    <tr class="bg-white">
                                        <td class="px-6 whitespace-nowrap text-sm font-medium border-black border font-bold">
                                            Arrivée aller
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            à {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->addSecond($trajet['aller_distance']['duration_second'])->translatedFormat('h:i') }}
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['aller_point_arriver'] }}
                                        </td>
                                    </tr>

                                    <tr class="bg-white">
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold">
                                            Départ retour
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            le {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
                                            à {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'] ?? '')->translatedFormat('h:i') }}                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['retour_point_depart'] }}
                                        </td>
                                    </tr>

                                    <tr class="bg-white">
                                        <td class="px-6 whitespace-nowrap text-sm font-medium border-black border font-bold">
                                            Arrivée retour
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            à {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'] ?? '')->addSecond($trajet['retour_distance']['duration_second'])->translatedFormat('h:i') }}
                                        </td>
                                        <td class="px-6 whitespace-nowrap text-sm border-black border font-bold text-center">
                                            {{ $trajet['retour_point_arriver'] }}
                                        </td>
                                    </tr>

                                @endforeach


                                </tbody>
                            </table>
                            @foreach(($devis->data['trajets'] ?? []) as $index => $trajet)
                                <livewire:crmautocar::mon-auto-car-recap-devis :devis="$devis" :trajet-id="$index" :brand="$brand"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
