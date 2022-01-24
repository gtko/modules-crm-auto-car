<div>

    @if($invoices->count() > 0)
        <div class="flex justify-end items-center space-x-1">

            <select>
                @foreach($devis as $devi)
                    <option value="{{$devi->ref}}">Devis {{$devi->ref}}</option>
                @endforeach
            </select>

            <button class="btn btn-primary" wire:click="createInvoice">
                Ajouter
            </button>
        </div>
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
                    <tr>
                        <td class="border-b dark:border-dark-5">
                            {{$invoice->number}}
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
                                <a class="flex items-center mr-3 cursor-pointer" target="_blank" href="{{route('invoices.show', $invoice->id)}}">
                                    @icon('show', null, 'mr-2')
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{$invoices->links()}}
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

                    <select wire:model="devis_select">
                        <option>Choisir un Devis</option>
                        @foreach($devis as $devi)
                            <option value="{{$devi->id}}">Devis {{$devi->ref}}</option>
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
