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
