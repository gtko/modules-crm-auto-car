<tr>

    <th class="whitespace-nowrap">#</th>
    <th class="whitespace-nowrap">Client</th>
    <th class="whitespace-nowrap">Etat</th>
    <th class="whitespace-nowrap">PV / PA</th>
    <th class="whitespace-nowrap">Marge HT</th>
    <th class="whitespace-nowrap">Fournisseur</th>
    <th class="whitespace-nowrap">Date Départ</th>
    <th class="whitespace-nowrap">Date Retour</th>
    <th class="whitespace-nowrap">A encaisser</th>

    <td class="w-40">
        {{$proformat->number}}
    </td>
    <td>
        <a href="" class="font-medium whitespace-nowrap">
            {{$proformat->devis->dossier->client->format_name}}
            <small>{{$proformat->created_at->format('d/m/Y H:i')}}</small>
        </a>
        <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">
            <a href="{{route('devis.edit', [$proformat->devis->dossier->client, $proformat->devis->dossier, $proformat->devis])}}">devis#{{$invoice->$proformat->ref}}</a>
        </div>
    </td>

    <td class="text-center">
        ICI les icons d'état
    </td>

    <td class="text-center">
        <div class="flex flex-col">
            <small>PV : @marge($price->getPriceHT())€</small>
            <small>PA : @marge($price->getPriceHT())€</small>
        </div>
    </td>
    <td class="text-center">@marge($price->getPriceTVA())€ ({{$price->getTauxTVA()}}%)</td>
    <td class="text-center">@marge($price->getPriceTTC())€</td>

    <td class="text-center text-red-800">-600€</td>


    <td class="table-report__action w-56">
        <div class="flex justify-center items-center">
                <span class="flex items-center mr-3" wire:click="show()">
                    @icon('show', null, 'mr-2') Voir
                </span>
            <span class="flex items-center mr-3" wire:click="editer()">
                    @icon('edit', null, 'mr-2') Editer
                </span>
            <span class="flex items-center mr-3" wire:click="avoir()">
                    @icon('invoice', null, 'mr-2') Avoir
                </span>

            <span class="flex items-center" wire:click="pdf()">
                    @icon('pdf', null, 'mr-2') Télécharger
                </span>

            @push('modals')
                <livewire:basecore::modal
                    name="avoir_{{$invoice->id}}"
                    :type="Modules\BaseCore\Entities\TypeView::TYPE_LIVEWIRE"
                    path='crmautocar::create-avoir'
                    :arguments="['invoice' => $invoice]"
                />
            @endpush
        </div>
    </td>
</tr>
