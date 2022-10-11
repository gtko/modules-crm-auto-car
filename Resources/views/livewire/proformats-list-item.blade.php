<tr class="{{$class}} @if($proformat->hasCancel()) filter bg-gray-300 grayscale @endif">
    <td class="px-2 py-3 text-sm font-medium whitespace-nowrap ">
        {{$proformat->number}}
        <div class="flex flex-col">
            <small>
                <a href="{{route('dossiers.show', [$proformat->devis->dossier->client, $proformat->devis->dossier])}}">
                    dossier:{{$proformat->devis->dossier->ref}}
                </a>
            </small>
            <small>
                <a href="{{route('devis.show', [$proformat->devis->dossier->client, $proformat->devis->dossier, $proformat->devis])}}">
                    devis:{{$proformat->devis->ref}}
                </a>

            </small>
        </div>
    </td>
    @if($proformat->devis->dossier ?? false)
    <td class="px-2 py-3 text-sm">
        <div class="flex flex-col">
        <a href="{{route('dossiers.show', [$proformat->devis->dossier->client, $proformat->devis->dossier])}}" class="font-medium whitespace-nowrap">
            {{\Illuminate\Support\Str::limit($proformat->devis->dossier->client->format_name,30)}}
            @if($proformat->devis->dossier->client->company)
                <br>  {{\Illuminate\Support\Str::limit($proformat->devis->dossier->client->company, 30)}}
            @endif
        </a>

        @if($proformat->hasCancel())
            <span class="text-red-600 whitespace-nowrap">(Annulé)</span>
        @else
            @if($proformat->acceptation_date)
                <small class="whitespace-nowrap"> Accepté le {{$proformat->acceptation_date->format('d/m/Y H:i')}}</small>
            @else
                <small class="text-red-500 whitespace-nowrap">Non accepté</small>
            @endif
        @endif

        <div class="text-xs whitespace-nowrap mt-0.5">
            <a href="{{route('devis.edit', [$proformat->devis->dossier->client, $proformat->devis->dossier, $proformat->devis])}}">devis#{{$proformat->devis->ref}}</a>
        </div>
        </div>
    </td>

    <td class="px-2 py-3 text-sm text-gray-500 whitespace-nowrap">
        <div class="flex flex-col">
            <div class="whitespace-nowrap">PV : @marge($price->getPriceVenteTTC())€</div>
            <div class="whitespace-nowrap">PA : @marge($price->getPriceAchat())€</div>
            <div class="whitespace-nowrap">AC : @marge($price->getAcompteTTC())€</div>
        </div>
    </td>

    <td class="px-2 py-3 text-sm whitespace-nowrap">
        <div class="flex items-center">
            @if(!$editMargeActive)
                <span wire:click="editMarge()" class="@if($price->achatValidated()) text-green-600 @else text-gray-600 @endif">
                    @marge($marge)€
                </span>
                <span wire:click="editMarge()" class="ml-1 cursor-pointer hover:text-blue-600" >@icon('edit', 14, '')</span>
            @else
                <input type="number" wire:model.defer="marge" wire:keyup.enter="storeMarge" wire:keyup.escape="closeMarge"/>
                <span wire:click="storeMarge"  class="ml-2 cursor-pointer hover:text-blue-600">@icon('checkCircle', null, 'mr-2')</span>
                <span wire:click="closeMarge"  class="ml-1 text-red-200 cursor-pointer hover:text-red-600">@icon('close', null, '')</span>
            @endif

        </div>
    </td>
    <td class="px-2 py-3 text-sm whitespace-nowrap">
        @marge($price->getSalaireDiff())€
    </td>
    <td class="px-2 py-3 text-sm whitespace-nowrap">
        <div class="flex flex-col">
        @forelse($proformat->devis->demandeFournisseurs->whereIn('status', [
            Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur::STATUS_BPA,
            \Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur::STATUS_VALIDATE,
            \Modules\CrmAutoCar\Models\Traits\EnumStatusCancel::STATUS_CANCELED,
            \Modules\CrmAutoCar\Models\Traits\EnumStatusCancel::STATUS_CANCELLER,
    ])->where('prix', '!=', 0) as $demande)
            @switch($demande->status)
                @case(\Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur::STATUS_BPA)
                    <div class="text-blue-500 whitespace-nowrap">
                        @break
                @case(\Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur::STATUS_VALIDATE)
                    <div class="text-green-500 whitespace-nowrap">
                @break
                @case(\Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur::STATUS_VALIDATE)
                    <div class="text-red-700 whitespace-nowrap">
                @break
                @default()
                    <div class="text-red-500 whitespace-nowrap">
                @break
            @endswitch
                    {{$demande->fournisseur->data['company'] ??' N/A'}}
                </div>
        @empty
            <div class="text-red-500">Aucun fournisseur</div>
        @endforelse
        </div>
    </td>

    <td class="px-2 py-3 text-sm whitespace-nowrap">
        @if(!is_string($proformat->devis->date_depart))
        {{$proformat->devis->date_depart->format('d/m/Y H:i') ?? 'N/A'}}
        @else
            {{$proformat->devis->date_depart}}
        @endif
    </td>
    <td class="px-2 py-3 text-sm whitespace-nowrap">
        @if(!is_string($proformat->devis->date_retour))
            {{$proformat->devis->date_retour->format('d/m/Y H:i') ?? 'N/A'}}
        @else
            {{$proformat->devis->date_retour}}
        @endif
    </td>
    <td class="px-2 py-3 text-sm whitespace-nowrap">
        @if($proformat->devis->isMultiple)
            <span class="px-3 py-1 text-blue-800 bg-blue-200 rounded-full">Oui ({{count($proformat->devis->data['trajets'])}})</span>
        @else
            <span class="px-3 py-1 text-gray-800 bg-gray-200 rounded-full">Non</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-2 py-3 text-sm  @if($price->remains() == 0) text-green-500 @else text-red-800 @endif">
        @marge($price->remains())€
    </td>

    <td class="relative whitespace-nowrap">
        <div class="flex items-center justify-center">
            <a class="flex items-center cursor-pointer" target="_blank" href="{{route('dossiers.show', [$proformat->devis->dossier->client, $proformat->devis->dossier])}}">
                @icon('edit', null, 'mr-2')
            </a>
            <a class="flex items-center cursor-pointer" target@="_blank" href="{{route('proformats.show', $proformat->id)}}">
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
