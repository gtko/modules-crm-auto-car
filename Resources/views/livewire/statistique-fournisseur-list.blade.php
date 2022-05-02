<div class="overflow-x-auto bg-white ">
    <table class="table overflow-visible">
        <thead>
        <tr>
            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">ID Devis</th>
            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">ID Dossier</th>
            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Client</th>
            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Fournisseur</th>
            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Prix Fournisseur</th>
            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Montant Reglé</th>
            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Reste à Reglé</th>
            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Départ le</th>
            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Retour le</th>
            <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Nbr de paiements</th>
        </tr>
        </thead>
        <tbody>
        @foreach($decaissements as $devis)
            <tr class="@if($devis->decaissements->count() > 0 && $devis->decaissements->sum('restant') == 0) bg-green-500 @elseif($devis->decaissements->sum('restant') < 0) bg-red-500 text-white @endif">
                <td class="border-b dark:border-dark-5">
                    <a target="_blank" class="cursor-pointer text-blue-500" href='{{route('devis.edit', [$devis->dossier->client, $devis->dossier, $devis])}}'>
                        {{ $devis->ref }}
                    </a>
                </td>
                <td class="border-b dark:border-dark-5">
                    <a target="_blank" class="cursor-pointer text-blue-500" href='{{route('dossiers.show', [$devis->dossier->client, $devis->dossier])}}'>
                        {{ $devis->dossier->ref }}
                    </a>
                </td>
                <td class="border-b dark:border-dark-5">{{ $devis->dossier->client->formatName }}</td>
                <td class="border-b dark:border-dark-5">{{ $devis->dossier->client->formatName }}</td>
                <td class="border-b dark:border-dark-5">@marge($devis->pivot->prix ?? 0)€</td>
                <td class="border-b dark:border-dark-5">@marge($devis->decaissements->sum('payer'))€</td>
                <td class="border-b dark:border-dark-5">@marge($devis->decaissements->sum('restant'))€</td>
                <td class="border-b dark:border-dark-5">
                    @if(!empty($devis->date_depart))
                        {{ $devis->date_depart->format('d/m/Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td class="border-b dark:border-dark-5">
                    @if(!empty($devis->date_retour))
                        {{ $devis->date_retour->format('d/m/Y') }}
                    @else
                        N/A
                    @endif
                </td>
                <td class="border-b dark:border-dark-5">
                    {{ $devis->decaissements->count() }}
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

</div>
