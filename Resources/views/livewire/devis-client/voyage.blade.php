<div class="p-4">
    <div class="mb-8">
        <hr class="text-bleu">
        <h5 class="text-bleu my-2 pl-2 font-bold text-xl">
            @if($devis->isMultiple)
                Votre voyages n° {{$trajetId+1}}
            @else
                Votre voyage
            @endif
        </h5>
        <hr class="text-bleu">
    </div>


    <div class="flex flex-col md:mt-4 mt-2">

        <div class="p-3">
            <div>
                <span>Départ de </span>
                <span class="font-bold">{{ $trajet['aller_distance']['origin_formatted'] ?? '' }} </span>
                <span>vers </span>
                <span class="font-bold">{{ $trajet['aller_distance']['destination_formatted'] ?? '' }} </span>
            </div>
            <div>
                Date :
                @if($trajet['aller_date_depart'] ?? false)
                    {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
                @else
                    Aucune date
                @endif
            </div>
            <div>
                <span>Heure de Départ : </span>
                <span class="font-bold">
                             @if($trajet['aller_date_depart'] ?? false)
                        {{ \Carbon\Carbon::createFromTimeString($trajet['aller_date_depart'] ?? '')->format('h:i') }}
                    @else
                        Aucune heure
                    @endif

                        </span>
            </div>
            <div>
                <div>
                    <span>Nombre de voyageurs : </span>
                    <span class="font-bold">{{ $trajet['aller_pax'] ?? ''}}</span>
                </div>
            </div>
        </div>
        @if($trajet['retour_date_depart'] ?? false)
            <div class="mt-5 p-3">
                <div>
                    Retour le :
                    @if($trajet['retour_date_depart'] ?? false)
                        {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
                    @else
                        Aucune date de retour
                    @endif
                </div>
                <div>
                    <span>Départ de </span>
                    <span class="font-bold">{{ $trajet['aller_distance']['destination_formatted'] ?? '' }} </span>
                    <span>vers </span>
                    <span class="font-bold">{{ $trajet['aller_distance']['origin_formatted'] ?? '' }} </span>
                </div>
                <div>
                    <span>Heure de Départ : </span>
                    <span class="font-bold">
                            @if($trajet['retour_date_depart'] ?? false)
                            {{ \Carbon\Carbon::createFromTimeString($trajet['retour_date_depart'] ?? '')->format('h:i') }}
                        @else
                            Aucune date de retour
                        @endif
                        </span>
                </div>
                <div>
                    <div>
                        <span>Nombre de voyageurs : </span>
                        <span class="font-bold">{{ $trajet['retour_pax'] ?? ''}}</span>
                    </div>
                </div>
            </div>
        @endif


            <livewire:crmautocar::devis-client.recap-devis
                :devis="$devis"
                :brand="$brand"
                :trajet-id="$trajetId"
                :class="'p-4 grid justify-items-stretch mb-4'"
                :proformat="$proformat"
            />

    </div>

    @if(($trajet['commentaire'] ?? false))

        <div class="mb-4">
            <h5 class="text-bleu my-2 pl-2 font-bold text-xl">Commentaire</h5>
            <hr class="text-bleu">
        </div>
        <div>
            <span> {{$trajet['commentaire']}}</span>
        </div>


    @endif
</div>
