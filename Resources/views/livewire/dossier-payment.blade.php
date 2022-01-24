<div>

    @if($proformats->count() === 0)
        <div class="text-center p-8">
            @icon('empty', null, 'mx-auto h-12 w-12 text-gray-400')
            <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune facture</h3>
            <p class="mt-1 text-sm text-gray-500">
                Aucune facture emise sur le dossier
            </p>
        </div>
    @else
        <div class="grid grid-cols-12 mt-4">

            <select wire:model="paiement_proformat" class="form-control-sm col-span-6 mr-1">
                <option>Choisir une proformat</option>
                @foreach($proformats as $proformat)
                    <option value="{{$proformat->id}}">Facture proformat{{$proformat->number}}</option>
                @endforeach
            </select>

            <select wire:model="paiement_type" class="form-control-sm col-span-6">
                <option value="">Type de paiement</option>
                <option value="virement">Virement</option>
                <option value="cheque">Chèque</option>
                <option value="carte">Carte bancaire</option>
            </select>

            <input type="number" step="0.00" wire:model="paiement_total" class="form-control-sm col-span-4 mt-1 mr-1"/>

            <x-basecore::inputs.date name="paiement_date" class="col-span-4 form-control-sm mt-1 mr-1"
                                     wire:model="paiement_date"/>

            <button class="btn btn-primary form-control-sm col-span-4 mt-1 ml-1" wire:click="addPaiment">Ajouter
            </button>

        </div>

        <div>
            <div class="overflow-x-auto">
                <table class="table mt-5">
                    <thead>
                    <tr class="text-gray-700">
                        <th class="whitespace-nowrap" colspan="6">
                            {{$payments->count()}} Paiements
                        </th>
                    </tr>
                    <tr class="bg-gray-100 text-gray-700">
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">Invoice</th>
                        <th class="whitespace-nowrap">Date</th>
                        <th class="whitespace-nowrap">total</th>
                        <th class="whitespace-nowrap">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td class="border-b dark:border-dark-5">
                                {{$payment->id}}
                            </td>
                            <td class="border-b dark:border-dark-5">
                                {{$payment->proformat->number}}
                            </td>
                            <td class="border-b dark:border-dark-5">
                                @if($payment->date_payment ?? false)
                                    {{$payment->date_payment}}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="border-b dark:border-dark-5">
                                {{ $payment->total}}€
                            </td>
                            <td class="border-b dark:border-dark-5">
                                <div class="flex justify-center items-center">
                                    <span class="cursor-pointer" wire:click="delete({{$payment}})">
                                        @icon('delete', null, 'mr-2')
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{$payments->links()}}
            </div>
        </div>
    @endif

</div>
