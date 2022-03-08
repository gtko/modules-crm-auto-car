<div class="{{$class}}">
    @if((!$proformat ?? true))
        <h4 class="text-bleu font-bold text-xl ">Notre proposition tarifaire</h4>
        <hr class="mt-4 mb-6  no-print">

        <table class="border border-gray-600 w-full border-collapse @if($sidebar) hidden lg:block no-print @endif">

            @if($price->getTrajets()->count() > 0 )
            <tr class="bg-gray-200 border border-gray-600 border-collapse w-full">
                <th scope="row" class=" text-left p-3 text-gray-600">
                    Transport en Autocar
                </th>
                <td class="w-1/3 text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                    @marge($price->getPriceHT())€
                </td>
            </tr>
            @endif

            @foreach($price->getLines() as $line)
                    <tr class="bg-gray-200 border border-gray-600 border-collapse w-full">
                        <th scope="row" class=" text-left p-3 text-gray-600">
                           {{$line->getLine()}}
                        </th>
                        <td class="w-1/3 text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                            @marge($line->getPriceHT())€
                        </td>
                    </tr>
            @endforeach

            @if ($price->getPriceTVA() > 0)
                <tr class="bg-gray-200 w-full">
                    <th scope="row"
                        class="w-1/3 text-left p-3 text-gray-600 border border-gray-600 border-collapse">
                        Total H.T
                    </th>
                    <td class="text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                        @marge($price->getPriceHT())€
                    </td>
                </tr>

                <tr class="w-full">
                    <th scope="row"
                        class="w-1/3 text-left p-3 text-gray-600 border border-gray-600 border-collapse">
                        TVA 10 %
                    </th>

                    <td class="text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                        @marge($price->getPriceTVA())€
                    </td>
                </tr>
            @endif
        </table>
        <div
            class="border border-2 border-bleu bg-bleu-light mt-2 p-3 flex justify-between items-center  @if(!$sidebar) sm:w-2/3 w-full justify-self-end @else hidden lg:flex justify-between  @endif">
            <span class="text-bleu text-xl">TOTAL T.T.C</span>
            <span class="text-bleu text-3xl font-bold">   @marge($price->getPriceTTC())€</span>
        </div>
    @endif
    @if(!$sidebar)
        <div class="flex-col flex no-print" style="font-size: 12px">
            @if(!empty(($devis->data['trajets'] ?? [])))
                <span>* Le prix ne comprend pas les élements suivants qui resteront à votre charge : Kilomètres supplémentaires et heures supplémentaires
                     @if (!($trajet['inclus_peages'] ?? false))
                        ,le péages
                    @endif
                    @if(!($trajet['inclus_parking'] ?? false))
                        ,le parking
                    @endif
                    @if (!($trajet['inclus_hebergement'] ?? false))
                        ,l'hébergement
                    @endif
                    @if (!($trajet['inclus_repas_chauffeur'] ?? false))
                        ,le repas chauffeur
                    @endif
                    .</span>
                @if (($trajet['inclus_peages'] ?? false) || ($trajet['inclus_parking'] ?? false) || ($trajet['inclus_hebergement'] ?? false) || ($trajet['inclus_repas_chauffeur'] ?? false))
                    <span>* Le prix comprend les élements suivants :
                        @if (($trajet['inclus_peages'] ?? false))
                            le péages,
                        @endif
                        @if($trajet['inclus_parking'] ?? false)
                            le parking,
                        @endif
                        @if ($trajet['inclus_hebergement'] ?? false)
                            l'hébergement,
                        @endif
                        @if ($trajet['inclus_repas_chauffeur'] ?? false)
                            le repas chauffeur
                        @endif
                </span>
                @endif
            @endif
            @if((!$proformat ?? true))
                <span>** Ce devis est valable 7 jours à compter de sa date d'envoi et sous réserve de disponibilité. Au-delà, le tarif sera soumis à révision.</span>
            @endif
        </div>

    @else
        <livewire:crmautocar::devis-client.accepte-devis :devi="$devis" :class="'w-full no-print'"/>
    @endif
</div>
