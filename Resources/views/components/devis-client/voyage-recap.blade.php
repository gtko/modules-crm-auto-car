<div {{ $attributes->merge(['class' => '']) }}>
    <div class="py-12 text-center"
         style="background-image: url('/assets/img/autocar.jpg'); background-size: cover; background-position: center; position: relative">
        <span class="text-white text-2xl font-bold z-30 relative">
            VOTRE DEVIS
            @if(!empty(($devis->data['trajets'] ?? [])))
                POUR UNE LOCATION D'AUTOCAR
            @endif
        </span>
        <div class="z-20 absolute top-0 right-0 left-0 bottom-0"
             style="background-color: rgba(0,0,0,0.5)"></div>
    </div>
    <div>
                    <span class="flex justify-between px-4 pt-6 pb-2 text-gray-700">
                        <span class="flex items-center">
                            <span class="mr-4">Devis
                                <span class="font-bold">#{{$devis->ref}}</span>
                            </span>
                            <span onclick="window.print()" class="flex flex-row items-center cursor-pointer no-print">
                                <span>@icon('print', '18')</span>
                                <span class="ml-1"> Imprimer</span>
                            </span>
                            <a class='ignore-link flex ml-4 no-print' href="{{route('pdf-devis-download', $devis)}}" target="_blank">
                                <span>@icon('pdf', null, 'w-4 h-4 mr-1')</span>
                               <span>Télécharger</span>
                            </a>
                        </span>
                        <span>{{ $devis->created_at->format('d/m/Y') }}</span>
                    </span>
    </div>
    <div style="background-color: #ebf3f7" class="m-4 p-4 space-y-6 text-base">
        <div>Bonjour
            @if($devis->dossier->client->personne->gender === 'male') Monsieur @elseif($devis->dossier->client->personne->gender === 'female') Madame @endif
            {{ $devis->dossier->client->format_name ?? '' }}, {{ $devis->dossier->client->company ?? '' }}</div>
        @if(!empty(($devis->data['trajets'] ?? [])))
            <div>
                C'est avec plaisir que nous vous envoyons notre offre pour
                @if($devis->isMultiple)
                    vos trajets
                @else
                    votre trajet
                @endif
                au départ de :
                <ul>
                    @foreach(($devis->data['trajets'] ?? []) as $trajet)
                        <li>
                            @if(($trajet['aller_distance']['origin_formatted'] ?? false) && ($trajet['aller_date_depart'] ?? false))
                                <span class="font-bold">{{ $trajet['aller_distance']['origin_formatted'] ?? '' }}, le {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('l d F Y') }}.</span>
                            @else
                                <span class="font-bold">Aucune date</span>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>


            <div class="no-print">En cliquant sur « Réservez le trajet en Autocar » , vous serez redirigé sur notre site
                internet
                où vous pourrez réserver votre autocar en toute simplicité.
            </div>
        @else
            <div>
                {{$devis->data['entete'] ?? ''}}
            </div>
        @endif
    </div>

</div>
