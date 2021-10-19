<tr>
        <td class="w-40">
            {{$invoice->number}}
        </td>
        <td>
            <a href="" class="font-medium whitespace-nowrap">
                {{$invoice->devis->dossier->client->format_name}}
            </a>
            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">
                Ici les destinations aller / retour
            </div>
        </td>
        <td class="text-center">@marge($price->getPriceHT())€</td>
        <td class="text-center">@marge($price->getPriceTVA())€ ({{$price->getTauxTVA()}}%)</td>
        <td class="text-center">@marge($price->getPriceTTC())€</td>
        <td class="text-center text-red-800">-600€</td>
        <td class="text-center">
            <span class="flex justify-center items-center cursor-pointer" wire:click="paiements()">
                1
                @icon('show', '16', 'ml-2')
            </span>
        </td>
        <td class="w-40">
            <div class="flex items-center justify-center text-red-400">
                Paiement partiel
            </div>
        </td>
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
