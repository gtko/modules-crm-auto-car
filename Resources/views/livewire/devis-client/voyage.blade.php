<div class="p-4">
    <div class="mb-8">
        <hr class="text-bleu">
        <h5 class="text-bleu my-2 pl-2 font-bold text-xl">
            @if($devis->isMultiple)
                Vos voyages
            @else
                Votre voyage
            @endif
        </h5>
        <hr class="text-bleu">
    </div>

    @foreach(($devis->data['trajets'] ?? []) as $idTrajet => $trajet)
        <div class="grid grid-cols-3 md:mt-4 mt-2">
            <div class="col-span-3 md:col-span-1 p-3 md:border-t border-bleu">
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
                        <span>Nombre de voyageur : </span>
                        <span class="font-bold">{{ $trajet['aller_pax'] ?? ''}}</span>
                    </div>
                </div>
            </div>
            <div class="col-span-3 md:col-span-1 mt-5 p-3 md:mt-0 md:border-t border-bleu">
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
                        <span>Nombre de voyageur : </span>
                        <span class="font-bold">{{ $trajet['retour_pax'] ?? ''}}</span>
                    </div>
                </div>
            </div>
            <div class="col-span-3 mt-5 p-3 md:mt-0 md:order-4">
                <div class="flex-col flex" style="font-size: 9px">
                    <span>* Le prix ne comprend pas les élements suivants qui resteront à votre charge :
                       @if($trajet['nom_inclus_parking'] ?? '')Parking,  @endif
                       @if ($trajet['non_inclus_hebergement'] ?? '') Hébergement, @endif
                       @if ($trajet['non_inclus_repas_chauffeur'] ?? '') Repas chauffeur, @endif
                       @if ($trajet['non_inclus_peages'] ?? '') Péages, @endif
                       Kilomètres supplémentaires et heures supplémentaires.
                    </span>
                </div>
            </div>
            <div class="col-span-3 md:col-span-1 mt-3 md:mt-0 border border-2 border-bleu bg-bleu-light">
                @php($price = (new Modules\DevisAutoCar\Entities\DevisTrajetPrice($devis,$idTrajet,$brand)))
                <table class="p-3 flex flex-col justify-end items-end w-full text-gray-600">
                    <tr><td class="px-2">Transport en Autocar</td>	<td class="text-right">@marge($price->getPriceHT())€</td></tr>
                    @if($trajet['inclus_parking'] ?? '')
                        <tr><td class="px-2">Parking</td>	<td class="text-right">Inclus</td></tr>
                    @endif
                    @if ($trajet['inclus_hebergement'] ?? '')
                        <tr><td class="px-2">Hébergement</td>	<td class="text-right">Inclus</td></tr>
                    @endif
                    @if ($trajet['inclus_repas_chauffeur'] ?? '')
                        <tr><td class="px-2">Repas chauffeur</td>	<td class="text-right">Inclus</td></tr>
                    @endif
                    @if ($trajet['inclus_peages'] ?? '')
                        <tr><td class="px-2">Péages</td>	<td class="text-right">Inclus</td></tr>
                    @endif

                    <tr><td class="px-2">Frais de dossier</td>	<td class="text-right">Inclus</td></tr>

                    <tr><td class="px-2">Total H.T</td>	<td class="text-right">@marge($price->getPriceHT())€</td></tr>
                    <tr><td class="px-2">TVA 10 %</td>	<td class="text-right">@marge($price->getPriceTVA())€</td></tr>
                </table>
                <div class="p-3 flex justify-end items-center w-full">
                    <span class="text-bleu text-xl mr-2">TOTAL H.T</span>
                    <span class="text-bleu text-xl font-bold">@marge($price->getPriceTTC())€</span>
                </div>
            </div>
        </div>
    @endforeach

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

    </div>
</div>
