<tr>


    <td class="w-40">
        {{$proformat->number}}
    </td>
    <td>
        <div class="flex flex-col">
        <a href="{{route('dossiers.show', [$proformat->devis->dossier->client, $proformat->devis->dossier])}}" class="font-medium whitespace-nowrap">
            {{$proformat->devis->dossier->client->format_name}}
        </a>
        <small class="whitespace-nowrap">signé le {{$proformat->created_at->format('d/m/Y H:i')}}</small>
        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">
            <a href="{{route('devis.edit', [$proformat->devis->dossier->client, $proformat->devis->dossier, $proformat->devis])}}">devis#{{$proformat->devis->ref}}</a>
        </div>
        </div>
    </td>

    <td class="text-center">
       <div class="flex justify-between">
           <span class="rounded-full cursor-pointer p-1 hover:bg-gray-300 mr-2">@icon('edit')</span>
           <span class="rounded-full cursor-pointer p-1 hover:bg-gray-300 mr-2">@icon('bus')</span>
           <span class="rounded-full cursor-pointer p-1 hover:bg-gray-300 mr-2">@icon('cash')</span>
           <span class="rounded-full cursor-pointer p-1 hover:bg-gray-300 mr-2">@icon('phone')</span>
       </div>
    </td>

    <td class="text-center">
        <div class="flex flex-col">
            <div class="whitespace-nowrap">PV : @marge($price->getPriceVente())€</div>
            <div class="whitespace-nowrap">PA : @marge($price->getPriceAchat())€</div>
        </div>
    </td>

    <td class="text-center">@marge($price->getMargeHT())€</td>
    <td class="text-center">
        <div class="flex flex-col">
        @forelse($proformat->devis->fournisseursValidated as $fournisseur)
            <div class="whitespace-nowrap">{{$fournisseur->format_name}}</div>
        @empty
            <div class="text-red-500">Aucun fournisseur</div>
        @endforelse
        </div>
    </td>

    <td class="text-center">
        {{$proformat->devis->date_depart}}
    </td>
    <td class="text-center">
        {{$proformat->devis->date_retour}}
    </td>
    <td class="text-center text-red-800">-600€</td>

    <td class="table-report__action w-56">
        <div class="flex justify-center items-center">
            <span class="flex items-center mr-3" wire:click="show()">
                @icon('show', null, 'mr-2')
            </span>
            <span class="flex items-center" wire:click="pdf()">
                @icon('pdf', null, 'mr-2')
            </span>

        </div>
    </td>
</tr>
