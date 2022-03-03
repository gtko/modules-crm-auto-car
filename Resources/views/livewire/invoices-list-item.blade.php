<tr>
        <td class="w-40">
            {{$invoice->number}} @if($invoice->isRefund()) <span class="text-red-500">(Annulation)</span> @endif
        </td>
        <td>
            <a href="" class="font-medium whitespace-nowrap">
                {{$invoice->devis->dossier->client->format_name}}
            </a>
            <div class="text-gray-600 text-xs whitespace-nowrap mt-0.5">
               <a href="{{route('devis.edit', [$invoice->devis->dossier->client, $invoice->devis->dossier, $invoice->devis])}}">devis#{{$invoice->devis->ref}}</a>
            </div>
        </td>
        <td class="text-center">@marge($price->getPriceHT())€</td>
        <td class="text-center">@marge($price->getPriceTVA())€ ({{$price->getTauxTVA()}}%)</td>
        <td class="text-center">@marge($price->getPriceTTC())€</td>
        @if($price->remains() > 0)
            <td class="text-center text-red-800">
                @marge($price->remains())€
            </td>
        @else
            <td class="text-center text-green-800">
               0€
            </td>
        @endif
        <td>
            @if($price->hasOverPaid())
                <span class="text-red-700">
                    @marge($price->overPaid())€
                </span>
            @else
                <span class="text-gray-400">
                    0€
                </span>
            @endif
        </td>
        <td class="w-40">
            @if($price->hasOverPaid())
                <div class="flex items-center justify-center text-red-700">
                   Trop perçu
                </div>
            @elseif($price->hasRefund())
                <div class="flex items-center justify-center text-green-700">
                    Remboursé
                </div>
            @else
                @if($price->paid() === 0)
                    <div class="flex items-center justify-center text-gray-400">
                        Aucun paiement
                    </div>
                @elseif($price->remains() > 0)
                    <div class="flex items-center justify-center text-red-400">
                        Paiement partiel
                    </div>
                @else
                    <div class="flex items-center justify-center text-green-400">
                        Paiement validé
                    </div>
                @endif
            @endif
        </td>
        <td class="table-report__action w-56">
            <div class="flex justify-center items-center">
                <span class="cursor-pointer flex items-center mr-3" wire:click="show()">
                    @icon('show', null, 'mr-2')
                </span>
                <span class="cursor-pointer flex items-center mr-3" wire:click="editer()">
                    @icon('edit', null, 'mr-2')
                </span>
                <span class="cursor-pointer flex items-center mr-3" wire:click="avoir()">
                    @icon('invoice', null, 'mr-2')
                </span>

                <span class="cursor-pointer flex items-center mr-3" wire:click="pdf()">
                    @icon('pdf', null, 'mr-2')
                </span>

                @if($price->getPriceTTC() > 0)
                    <livewire:crmautocar::invoice-cancel :invoice="$invoice" />
                @endif

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
