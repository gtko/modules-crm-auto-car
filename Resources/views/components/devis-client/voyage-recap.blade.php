<div {{ $attributes->merge(['class' => '']) }}>
    <div class="py-12 text-center"
         style="background-image: url('/assets/img/autocar.jpg'); background-size: cover; background-position: center; position: relative">
        <span class="text-white text-2xl font-bold z-30 relative">VOTRE DEVIS POUR UNE LOCATION D'AUTOCAR</span>
        <div class="z-20 absolute top-0 right-0 left-0 bottom-0"
            style="background-color: rgba(0,0,0,0.5)"></div>
    </div>
    <div>
                    <span class="flex justify-between px-4 pt-6 pb-2 text-gray-700">
                        <span class="flex items-center">
                            <span class="mr-4">Devis
                                <span class="font-bold">{{$devis->ref}}</span>
                            </span>
                            <span class="flex flex-row items-center cursor-pointer">
                                <span>@icon('print', '18')</span>
                                <span class="ml-1"> Imprimer</span>
                            </span>
                        </span>
                        <span>{{ $devis->created_at->format('d/m/Y') }}</span>
                    </span>
    </div>
    <div style="background-color: #ebf3f7" class="m-4 p-4 space-y-6 text-base">
        <div>Bonjour {{ $devis->dossier->client->format_name ?? '' }},</div>
        <div>C'est avec plaisir que nous vous envoyons notre offre pour votre trajet au départ de
            @if($devis->data['aller_distance']['origin_formatted'] ?? false)
                <span class="font-bold">{{ $devis->data['aller_distance']['origin_formatted'] ?? '' }}, le {{ \Carbon\Carbon::createFromTimeString($devis->data['aller_date_depart'] ?? '')->translatedFormat('l d F Y') }}.</span>
            @else
                <span class="font-bold">Aucune date</span>
            @endif
        </div>
        <div>En cliquant sur « Réservez le trajet en Autocar » , vous serez redirigé sur notre site
            internet
            où vous pourrez réserver votre bus en toute simplicité.
        </div>
    </div>
    <div class="p-4">
        <div class="mb-8">
            <hr class="text-bleu">
            <h5 class="text-bleu my-2 pl-2 font-bold text-xl">Votre voyage</h5>
            <hr class="text-bleu">
        </div>
        <div>
            <div>
                <span>Départ de </span>
                <span class="font-bold">{{ $devis->data['aller_distance']['origin_formatted'] ?? '' }} </span>
                <span>vers </span>
                <span class="font-bold">{{ $devis->data['aller_distance']['destination_formatted'] ?? '' }} </span>
            </div>
            <div>
                Date :
                @if($devis->data['aller_date_depart'] ?? false)
                    {{ \Carbon\Carbon::createFromTimeString($devis->data['aller_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
                @else
                    Aucune date
                @endif
            </div>
            <div>
                <span>Heure de Départ : </span>
                <span class="font-bold">
                     @if($devis->data['aller_date_depart'] ?? false)
                        {{ \Carbon\Carbon::createFromTimeString($devis->data['aller_date_depart'] ?? '')->format('h:i') }}
                    @else
                        Aucune heure
                    @endif

                </span>
            </div>
        </div>
        <div class="mt-8">
            <div>
                Retour le :
                @if($devis->data['retour_date_depart'] ?? false)
                    {{ \Carbon\Carbon::createFromTimeString($devis->data['retour_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
                @else
                    Aucune date de retour
                @endif
            </div>
            <div>
                <span>Départ de </span>
                <span class="font-bold">{{ $devis->data['aller_distance']['destination_formatted'] ?? '' }} </span>
                <span>vers </span>
                <span class="font-bold">{{ $devis->data['aller_distance']['origin_formatted'] ?? '' }} </span>
            </div>
            <div>
                <span>Heure de Départ : </span>
                <span class="font-bold">
                    @if($devis->data['retour_date_depart'] ?? false)
                        {{ \Carbon\Carbon::createFromTimeString($devis->data['retour_date_depart'] ?? '')->format('h:i') }}
                    @else
                        Aucune date de retour
                    @endif
                </span>
            </div>
        </div>


        <div class="my-8">
            <hr class="text-bleu">
            <h5 class="text-bleu my-2 pl-2 font-bold text-xl">Informations complémentaires</h5>
            <hr class="text-bleu">
        </div>
        <div>
            <div>
                <span>Nombre d'autocar(s) : </span>
                <span class="font-bold">{{ $devis->data['nombre_bus'] ?? ''}}</span>
            </div>
            <div>
                <span>Nombre de conducteur(s) : </span>
                <span class="font-bold">{{ $devis->data['nombre_chauffeur'] ?? ''}}</span>
            </div>
            <div>
                <span>Nombre de participants : </span>
                <span class="font-bold">{{ $devis->data['aller_pax'] ?? ''}}</span>
            </div>
        </div>
    </div>
</div>
