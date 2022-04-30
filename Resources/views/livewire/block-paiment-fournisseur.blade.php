<div class="box mt-5 p-2">


    <div class="flex justify-start items-center p-4">
        <span>@icon('creditCard', 30, 'mr-2')</span>
        <span class="text-lg">Paiement Fournisseur</span>
    </div>
    <hr>

    <div class="px-2 pt-2">
        <x-basecore::inputs.select name="devi_id" label="" required="required" wire:model="devi_id">
            <option selected="selected">Devis</option>
            @foreach($dossier->devis as $devi)
                <option
                    value="{{ $devi->id}}">{{ $devi->ref }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </div>

    @if ($this->devi_id)

        <div class="px-2 pt-2">
            <x-basecore::inputs.select name="fournisseur_id" label="" required="required"
                                       wire:model="fournisseur_id">
                <option selected="selected">Fournisseur</option>
                @foreach($fournisseurs as $fourni)
                    <option
                        value="{{ $fourni->id}}">{{ $fourni->personne->firstname . ' ' . $fourni->personne->lastname }}</option>
                @endforeach
            </x-basecore::inputs.select>
        </div>

        @if ($this->fournisseur_id)

            <div class="px-2 pt-2">
                <x-basecore::inputs.date
                    name="date"
                    label="Date du paiment"
                    required="required"
                    wire:model="date"

                >
                </x-basecore::inputs.date>
            </div>

            <div class="px-2 pt-2">
                <x-basecore::inputs.number
                    name="payer"
                    label="Montant du paiment"
                    required="required"
                    wire:model="payer"
                >
                </x-basecore::inputs.number>
            </div>
            <div class="px-2 pt-2">
                <x-basecore::inputs.number
                    name="reste"
                    label="Reste à payer"
                    required="required"
                    wire:model="reste"
                    disabled
                >
                </x-basecore::inputs.number>
            </div>
            <div class="px-2 pt-2">
                <x-basecore::inputs.number
                    name="total"
                    label="Somme total"
                    required="required"
                    wire:model="total"
                    disabled
                >
                </x-basecore::inputs.number>
            </div>

            <div class="m-2">
                <x-basecore::button wire:click="payer">Payer</x-basecore::button>
            </div>
        @endif
    @endif

    <div>

        <table class="divide-y divide-gray-200 w-full mt-4">
            <thead class="bg-gray-200">
            <tr>
                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider">
                    Devi id
                </th>
                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider">
                    Fourni
                </th>

                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider">
                    Reste à payé
                </th>
                <th scope="col" class=" text-xs font-medium  uppercase tracking-wider">
                    Total
                </th>

                <th></th>

            </tr>
            </thead>
            <tbody>
            <!-- Odd row -->
            @php $total = 0 @endphp
            @foreach($paiements as $paiement)

                @php $total = $total + $paiement->payer @endphp
                <tr class="bg-white">
                    <td class="py-4 whitespace-nowrap text-sm font-medium text-center">
                        {{$paiement->devis->ref }}
                    </td>
                    <td class="py-4 whitespace-nowrap text-sm font-medium text-center">
                        {{$paiement->fournisseur->formatName }}
                    </td>
                    <td class="py-4 whitespace-nowrap text-sm text-center">
                        {{ $paiement->restant }}€
                    </td>
                    <td class="py-4 whitespace-nowrap text-sm text-center">
                        {{ $total + $paiement->restant }}€
                    </td>
                    <td>
                        <x-basecore::loading-replace>
                            <span wire:click="delete({{$paiement->id}})">
                                @icon('delete',20, 'cursor-pointer text-red-500 hover:text-red-700 w-6 h-6')
                            </span>
                        </x-basecore::loading-replace>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>


</div>
