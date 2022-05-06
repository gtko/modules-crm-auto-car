
<tr class="{{$class}}">
    <td class="w-40">
        {{$proformat->number}}
    </td>
    @if($proformat->devis->dossier ?? false)
    <td>
        <div class="flex flex-col">
        <a href="{{route('dossiers.show', [$proformat->devis->dossier->client, $proformat->devis->dossier])}}" class="font-medium whitespace-nowrap">
            {{$proformat->devis->dossier->client->format_name}}
            @if($proformat->devis->dossier->client->company)
                <br>  {{$proformat->devis->dossier->client->company}}
            @endif
        </a>
            <small class="whitespace-nowrap">signé le {{$proformat->created_at->format('d/m/Y H:i')}}</small>
        @if($proformat->acceptation_date)
            <small class="whitespace-nowrap"> Accepté le {{$proformat->acceptation_date->format('d/m/Y H:i')}}</small>
        @else
            <small class="text-red-500 whitespace-nowrap">Non accepté</small>
        @endif
        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">
            <a href="{{route('devis.edit', [$proformat->devis->dossier->client, $proformat->devis->dossier, $proformat->devis])}}">devis#{{$proformat->devis->ref}}</a>
        </div>
        </div>
    </td>

    <td class="text-center">
       <div class="flex justify-between">
           <a target='_blank' href='{{route('dossiers.show', [$proformat->devis->dossier->client,$proformat->devis->dossier])}}' class="rounded-full cursor-pointer p-1 hover:bg-gray-300 mr-2">
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
            <div class="whitespace-nowrap">PV : @marge($price->getPriceVenteTTC())€</div>
            <div class="whitespace-nowrap">PA : @marge($price->getPriceAchat())€</div>
            <div class="whitespace-nowrap">AC : @marge($price->getAcompteTTC())€</div>
        </div>
    </td>

    <td class="text-center whitespace-nowrap">
        <div class="flex items-center">
            @if(!$editMargeActive)
                <span wire:click="editMarge()" class="@if($price->achatValidated()) text-green-600 @else text-gray-600 @endif">
                    @marge($marge)€
                </span>
                <span wire:click="editMarge()" class="ml-1 cursor-pointer hover:text-blue-600" >@icon('edit', 14, '')</span>
            @else
                <input type="number" wire:model.defer="marge" wire:keyup.enter="storeMarge" wire:keyup.escape="closeMarge"/>
                <span wire:click="storeMarge"  class="ml-2 cursor-pointer hover:text-blue-600">@icon('checkCircle', null, 'mr-2')</span>
                <span wire:click="closeMarge"  class="ml-1 cursor-pointer text-red-200 hover:text-red-600">@icon('close', null, '')</span>
            @endif

        </div>
    </td>
    <td class="text-center whitespace-nowrap">
        @marge($price->getSalaireDiff())€
    </td>
    <td class="text-center">
        <div class="flex flex-col">
        @forelse($proformat->devis->fournisseursValidated as $fournisseur)
            <div class="whitespace-nowrap">{{$fournisseur->data['company'] ??' N/A'}}</div>


        @empty
            <div class="text-red-500">Aucun fournisseur</div>
        @endforelse
        </div>
    </td>

    <td class="text-center">
        @if(!is_string($proformat->devis->date_depart))
        {{$proformat->devis->date_depart->format('d/m/Y H:i') ?? 'N/A'}}
        @else
            {{$proformat->devis->date_depart}}
        @endif
    </td>
    <td class="text-center">
        @if(!is_string($proformat->devis->date_retour))
            {{$proformat->devis->date_retour->format('d/m/Y H:i') ?? 'N/A'}}
        @else
            {{$proformat->devis->date_retour}}
        @endif
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
    @else
        <td colspan="11"> Le devis n'existe plus</td>
    @endif
</tr>
