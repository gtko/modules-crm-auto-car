<div class="{{$class}}">
    @if((!$proformat ?? true))
        <h4 class="text-bleu font-bold text-xl @if($printable) no-print @endif">Notre proposition tarifaire</h4>
        <hr class="mt-4 mb-6  no-print">

        <table class="border border-gray-600 w-full border-collapse @if($sidebar) hidden lg:block no-print @endif">

            @if($sidebar)
                  @foreach($price->getTrajetsPrices() as $index => $trajetPrice)
                    <tr class="border border-gray-600 border-collapse w-full">
                        <th scope="row" class=" text-left p-3 text-gray-600 whitespace-nowrap">
                            Transport en Autocar @if($price->getTrajets()->count() > 1) #{{$index+1}} @endif
                        </th>
                        <td class="w-1/3 text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                            @marge($trajetPrice->getPriceHT())€
                        </td>
                    </tr>
                  @endforeach
            @else
                @if($price->getTrajets()->count() > 0 || $price instanceof Modules\DevisAutoCar\Entities\DevisTrajetPrice)
                <tr class="border border-gray-600 border-collapse w-full">
                    <th scope="row" class=" text-left p-3 text-gray-600">
                        Transport en Autocar
                    </th>
                    <td class="w-1/3 text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                        @marge($price->getPriceHT())€
                    </td>
                </tr>
                @endif

            @endif
            @if(method_exists($price,"getLines"))
                @foreach($price->getLines() as $line)
                        <tr class="border border-gray-600 border-collapse w-full">
                            <th scope="row" class=" text-left p-3 text-gray-600">
                               {{$line->getLine()}}
                            </th>
                            <td class="w-1/3 text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                                @marge($line->getPriceHT())€
                            </td>
                        </tr>
                @endforeach
            @endif

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

                <tr class="bg-gray-200 w-full">
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
            class="border border-2 border-bleu bg-bleu-light mt-2 p-3 flex justify-between items-center @if(!$printable) no-print @endif @if(!$sidebar) sm:w-2/3 w-full justify-self-end @else hidden lg:flex justify-between  @endif">
            <span class="text-bleu text-xl">TOTAL T.T.C</span>
            <span class="text-bleu text-3xl font-bold">   @marge($price->getPriceTTC())€</span>
        </div>
    @endif
    @if(!$sidebar)
        <div class="flex-col flex no-print" style="font-size: 12px">
            @if(!empty(($devis->data['trajets'] ?? [])))
                <span>* Le prix ne comprend pas les élements suivants qui resteront à votre charge :
                     @if (($trajet['peages'] ?? null) === 'non_compris')
                        Le péages,
                    @endif
                    @if(($trajet['parking'] ?? null) === 'non_compris')
                        Le parking,
                    @endif
                    @if (($trajet['hebergement'] ?? null) === 'non_compris')
                        L'hébergement,
                    @endif
                    @if (($trajet['repas_chauffeur'] ?? null) === 'non_compris')
                        Le repas chauffeur,
                    @endif
                      Kilomètres supplémentaires et Heures supplémentaires.
                    </span>
                @if (($trajet['peages'] ?? null)  === 'compris' || ($trajet['parking'] ?? null)  === 'compris' || ($trajet['hebergement'] ?? null)  === 'compris' || ($trajet['repas_chauffeur'] ?? null)  === 'compris')
                    <span>* Le prix comprend les élements suivants :
                        @if (($trajet['peages'] ?? null)  === 'compris')
                            Le péages,
                        @endif
                        @if(($trajet['parking'] ?? null)  === 'compris')
                            Le parking,
                        @endif
                        @if (($trajet['hebergement'] ?? null) === 'compris')
                            L'hébergement,
                        @endif
                        @if (($trajet['repas_chauffeur'] ?? null) === 'compris')
                            Le repas chauffeur,
                        @endif

                    </span>
                @endif

            @endif
            @if((!$proformat ?? true))
                <span>** Ce devis est valable 7 jours à compter de sa date d'envoi et sous réserve de disponibilité. Au-delà, le tarif sera soumis à révision.</span>
            @endif
        </div>

    @else
        <livewire:crmautocar::devis-client.accepte-devis :devi="$devis" :class="'w-full'"/>
    @endif
</div>
