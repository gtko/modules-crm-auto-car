
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
           <a href='{{route('dossiers.show', [$proformat->devis->dossier->client,$proformat->devis->dossier])}}' class="rounded-full cursor-pointer p-1 hover:bg-gray-300 mr-2">
               @icon('edit')
           </a>
           <span class="rounded-full cursor-pointer p-1 hover:bg-gray-300 mr-2
               @if(!($proformat->devis->data['validated'] ?? false)) text-red-600 @else text-green-600 @endif">
               @icon('bus')
           </span>
           <span class="rounded-full cursor-pointer p-1 hover:bg-gray-300 mr-2
               @if($proformat->price->paid() === 0 || $proformat->price->remains() > 0) text-red-600 @else text-green-600 @endif">
               @icon('cash')
           </span>
           <span class="rounded-full cursor-pointer p-1 hover:bg-gray-300 mr-2
               @if(($proformat->contactFournisseurs()->count() ?? 0) === 0) text-red-600 @else text-green-600 @endif">
               @icon('phone')
           </span>
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
    <td>
        @if($proformat->devis->isMultiple)
            <span class="text-blue-800 bg-blue-200 py-1 px-3 rounded-full">Oui ({{count($proformat->devis->data['trajets'])}})</span>
        @else
            <span class="text-gray-800 bg-gray-200 py-1 px-3 rounded-full">Non</span>
        @endif
    </td>
    <td class="text-center @if($price->remains() == 0) text-green-500 @else text-red-800 @endif">
        @marge($price->remains())€
    </td>

    <td class="table-report__action w-56">
        <div class="flex justify-center items-center">
            <a class="flex items-center mr-3 cursor-pointer" target="_blank" href="{{route('dossiers.show', [$proformat->devis->dossier->client, $proformat->devis->dossier])}}">
                @icon('edit', null, 'mr-2')
            </a>
            <a class="flex items-center mr-3 cursor-pointer" target@="_blank" href="{{route('proformats.show', $proformat->id)}}">
                @icon('show', null, 'mr-2')
            </a>
            <a class="flex items-center cursor-pointer" target="_blank"  href="{{route('proformats.pdf', $proformat->id)}}">
                @icon('pdf', null, 'mr-2')
            </a>

        </div>
    </td>
</tr>
