<div>

    @if($invoices->count() > 0)
        @if($proformas->count() > 0)
        <div class="flex justify-end items-center space-x-1">
            <select name="proformat_invoice_select" wire:model="proforma_select">
                @foreach($proformas as $proforma)
                    <option value="{{$proforma->id}}">Proforma {{$proforma->number}}</option>
                @endforeach
            </select>

            <button class="btn btn-primary" wire:click="createInvoice">
                Ajouter
            </button>
        </div>
        @endif
        <div>
        <div class="overflow-x-auto">
            <table class="table mt-5">
                <thead>
                <tr class="text-gray-700">
                    <th class="whitespace-nowrap" colspan="6">
                        {{$invoices->count()}} factures
                    </th>
                </tr>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Commercial</th>
                    <th class="whitespace-nowrap">Date</th>
                    <th class="whitespace-nowrap">devis</th>
                    <th class="whitespace-nowrap">total</th>
                    <th class="whitespace-nowrap">Déja payé</th>
                    <th class="whitespace-nowrap">Restant</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($invoices as $invoice)
                    <tr wire:key="$invoice->id">
                        <td class="border-b dark:border-dark-5">
                            {{$invoice->number}}
                            @if($invoice->hasCanceled())
                                <small class="text-red-600">(annulée)</small>
                            @endif
                        </td>
                        <td class="border-b dark:border-dark-5">
                            {{$invoice->devis->commercial->format_name}}
                        </td>
                        <td class="border-b dark:border-dark-5">
                            {{$invoice->created_at->format('d/m/Y H:i')}}
                        </td>
                        <td class="border-b dark:border-dark-5">
                            <a href="{{route('devis.edit', [$client, $dossier, $invoice->devis])}}">#{{$invoice->devis->ref}}</a>
                        </td>
                        <td class="border-b dark:border-dark-5">
                            {{ $invoice->devis->getTotal()}}€
                        </td>
                        <td class="border-b dark:border-dark-5">
                            {{$invoice->getPrice()->paid()}}€
                        </td>
                        <td class="border-b dark:border-dark-5">
                            {{$invoice->getPrice()->remains()}}€
                        </td>
                        <td class="border-b dark:border-dark-5">
                            <div class="flex justify-center items-center">
                                <livewire:crmautocar::send-invoice-email
                                    :invoice="$invoice"
                                    wire:key="'send_invoice' . $invoice->id"
                                />
                                <a class="flex items-center mr-3 cursor-pointer" target="_blank" href="{{(new Modules\BaseCore\Actions\Url\SigneRoute())->signer('invoices.show', [$invoice->id])}}">
                                    @icon('show', null, 'mr-2')
                                </a>
                                @if($invoice->getPrice()->getPriceTTC() > 0 && !$invoice->hasCanceled())
                                    <livewire:crmautocar::invoice-cancel :invoice="$invoice" />
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="text-center p-8">
            @icon('empty', null, 'mx-auto h-12 w-12 text-gray-400')
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune facture</h3>
            <p class="mt-1 text-sm text-gray-500">
                Aucune facture emise sur le dossier
            </p>

            @can('create', \Modules\CrmAutoCar\Models\Invoice::class)
                <div class="flex justify-center items-center space-x-1 mt-4">

                    <select name="proformat_invoice_select_v2" wire:model="proforma_select">
                        <option>Choisir une proforma</option>
                        @foreach($proformas as $proforma)
                            <option value="{{$proforma->id}}">Proforma {{$proforma->number}}</option>
                        @endforeach
                    </select>

                    <button class="btn btn-primary" wire:click="createInvoice">
                        Ajouter
                    </button>
                </div>
            @endcan
        </div>
    @endif

</div>
