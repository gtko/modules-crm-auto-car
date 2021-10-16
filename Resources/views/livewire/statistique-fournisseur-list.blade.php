


    <div class="overflow-x-auto bg-white ">
        <table class="table">
            <thead>
            <tr>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">ID Devis</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">ID Dossier</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Client</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Prix Fournisseur</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Montant Reglé</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Reste à Reglé</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Départ le</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Retour le</th>
            </tr>
            </thead>
            <tbody>
            @foreach($decaissements as $decaissement)
                <tr class="@if($decaissement->restant == 0) bg-green-500 @endif">
                    <td class="border-b dark:border-dark-5">
                        <a href=''>
                            {{ $decaissement->devis->ref }}
                        </a>
                    </td>
                    <td class="border-b dark:border-dark-5">{{ $decaissement->devis->dossier->ref }}</td>
                    <td class="border-b dark:border-dark-5">{{ $decaissement->devis->dossier->client->formatName }}</td>
                    <td class="border-b dark:border-dark-5">{{ $decaissement->payer + $decaissement->restant }}</td>
                    <td class="border-b dark:border-dark-5">{{ $decaissement->payer }}</td>
                    <td class="border-b dark:border-dark-5">{{  $decaissement->restant }}</td>
                    <td class="border-b dark:border-dark-5">
                        @isset($decaissement->devis->data['aller_date_depart'])
                            {{ \Carbon\Carbon::createFromTimeString($decaissement->devis->data['aller_date_depart'])->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td class="border-b dark:border-dark-5">
                        @isset($decaissement->devis->data['retour_date_depart'])
                            {{ \Carbon\Carbon::createFromTimeString($decaissement->devis->data['retour_date_depart'])->format('d/m/Y') }}
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

    </div>




