<tr>


    <td class="w-40">
        {{$proformat->number}}
    </td>
    <td>
        <a href="{{route('dossiers.show', [$proformat->devis->dossier->client, $proformat->devis->dossier])}}" class="font-medium whitespace-nowrap">
            {{$proformat->devis->dossier->client->format_name}}
            <small>{{$proformat->created_at->format('d/m/Y H:i')}}</small>
        </a>
        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">
            <a href="{{route('devis.edit', [$proformat->devis->dossier->client, $proformat->devis->dossier, $proformat->devis])}}">devis#{{$proformat->devis->ref}}</a>
        </div>
    </td>

    <td class="text-center">
        ICI les icons d'état
    </td>

    <td class="text-center">
        <div class="flex flex-col">
            <small>PV : @marge($price->getPriceVente())€</small>
            <small>PA : @marge($price->getPriceAchat())€</small>
        </div>
    </td>

    <td class="text-center">@marge($price->getMargeHT())€</td>
    <td class="text-center">Fournisseur</td>

    <td class="text-center text-red-800">
        départ
    </td>
    <td class="text-center text-red-800">
        arrivé
    </td>
    <td class="text-center text-red-800">-600€</td>

    <td class="table-report__action w-56">
        <div class="flex justify-center items-center">
            <span class="flex items-center mr-3" wire:click="show()">
                @icon('show', null, 'mr-2') Voir
            </span>
            <span class="flex items-center mr-3" wire:click="editer()">
                @icon('edit', null, 'mr-2') Editer
            </span>
            <span class="flex items-center" wire:click="pdf()">
                @icon('pdf', null, 'mr-2') Télécharger
            </span>

        </div>
    </td>
</tr>
