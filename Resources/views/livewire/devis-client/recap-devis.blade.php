<div class="{{$class}}">
    <h4 class="text-bleu font-bold text-xl">Notre proposition tarifaire</h4>
    <hr class="mt-4 mb-6">

    <table class="border border-gray-600 w-full border-collapse  @if($sidebar) hidden lg:block @endif">
        <tr class="bg-gray-200 border border-gray-600 border-collapse">
            <th scope="row" class="w-1/3 text-left p-3 text-gray-600">
                Transport en Autocar
            </th>
            <td class="w-1/3 text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                {{ $devis->data['brands']['1'] ?? '--' }} €
            </td>
        </tr>
        @if (($devis->data['inclus_peages'] ?? 0) > 0)
            <tr>
                <th scope="row"
                    class="text-left p-3 text-gray-600 border border-gray-600 border-collapse">
                    Péages
                </th>
                <td class="text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                    Inclus
                </td>
            </tr>
        @endif
        <tr>
            <th scope="row"
                class="w-1/3 text-left p-3 text-gray-600 border border-gray-600 border-collapse">
                Frais de dossier
            </th>
            <td class="text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                Inclus
            </td>
        </tr>


        @if ($devis->tva_applicable ?? false)
            <tr class="bg-gray-200">
                <th scope="row"
                    class="w-1/3 text-left p-3 text-gray-600 border border-gray-600 border-collapse">
                    Total H.T
                </th>
                <td class="text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                    {{ ($devis->data['brands']['1'] ?? 0) / 1.1}} €
                </td>
            </tr>

            <tr>
                <th scope="row"
                    class="w-1/3 text-left p-3 text-gray-600 border border-gray-600 border-collapse">
                    TVA 10 %
                </th>

                <td class="text-right pr-4 font-bold text-base border border-gray-600 border-collapse">
                    {{ ($devis->data['brands']['1'] ?? 0) - (($devis->data['brands']['1'] ?? 0) / 1.1)}} €
                </td>
            </tr>
        @endif
    </table>
    <div
        class="border border-2 border-bleu bg-bleu-light mt-2 p-3 flex justify-between items-center @if(!$sidebar) sm:w-2/3 w-full justify-self-end @else hidden lg:flex justify-between  @endif">
        <span class="text-bleu text-xl">TOTAL T.T.C</span>
        <span class="text-bleu text-3xl font-bold">{{ $devis->data['brands']['1'] ?? '--' }} €</span>
    </div>
    @if(!$sidebar)

        <div class="justify-self-end text-sm flex-col flex my-8 grid justify-items-stretch">
            @if (($devis->data['inclus_peages'] ?? '') || ($devis->data['inclus_parking'] ?? '')
                || ($devis->data['inclus_hebergement'] ?? '') || ($devis->data['inclus_repas_chauffeur'] ?? ''))
                <span>
                    Le tarif comprend :  @if($devis->data['inclus_parking'] ?? '')
                        Parking  @endif  @if ($devis->data['inclus_hebergement'] ?? '') -
                    Hébergement @endif @if ($devis->data['inclus_repas_chauffeur'] ?? '') - Repas
                    chauffeur @endif @if ($devis->data['inclus_peages'] ?? '') - Péages @endif</span>

            @endif
            @if(($devis->data['inclus_parking'] ?? '') || ($devis->data['non_inclus_hebergement'] ?? '') || ($devis->data['non_inclus_repas_chauffeur'] ?? '') || ($devis->data['non_inclus_peages'] ?? ''))
                <span>
                    Le tarif ne comprend pas :  @if($devis->data['nom_inclus_parking'] ?? '')
                        Parking  @endif  @if ($devis->data['non_inclus_hebergement'] ?? '') -
                    Hébergement @endif @if ($devis->data['non_inclus_repas_chauffeur'] ?? '') - Repas
                    chauffeur @endif @if ($devis->data['non_inclus_peages'] ?? '') - Péages @endif
                </span>
            @endif
        </div>

        <div class="flex-col flex" style="font-size: 9px">
            <span>* Le prix ne comprend pas les élements suivants qui resteront à votre charge : Kilomètres supplémentaires et heures supplémentaires.</span>
            <span>** Ce devis est valable 7 jours à compter de sa date d'envoi et sous réserve de disponibilité. Au-delà, le tarif sera soumis à révision.</span>
        </div>
    @else
        <livewire:crmautocar::devis-client.accepte-devis :devi="$devis"/>
    @endif
</div>
