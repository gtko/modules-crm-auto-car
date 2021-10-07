<div class="intro-y box mt-5 p-2">


    @push('modals')
        <livewire:basecore::modal
            name="popup-mail"
            :type="Modules\BaseCore\Entities\TypeView::TYPE_LIVEWIRE"
            path='crmautocar::form-email-send'
        />

    @endpush

    <div class="flex justify-start items-center p-4">
        <span>@icon('creditCard', 30, 'mr-2')</span>
        <span class="text-lg">Demande Fournisseur</span>
    </div>
    <hr>
    <div class="px-2 pt-2">
        <x-basecore::inputs.select name="devi_id" label="" required="required" wire:model.defer="devi_id">
            <option selected="selected">Devis</option>
            @foreach($dossier->devis as $devi)
                <option
                    value="{{ $devi->id}}">{{ $devi->ref }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </div>
    <div class="px-2 pt-2">
        <x-basecore::inputs.select name="fournisseur_id" label="" required="required"
                                   wire:model.defer="fournisseur_id">
            <option selected="selected">Fournisseur</option>
            @foreach($fournisseurs as $fourni)
                <option
                    value="{{ $fourni->id}}">{{ $fourni->personne->firstname . ' ' . $fourni->personne->lastname }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </div>
    <div class="px-2 pt-2">
        <x-basecore::inputs.number name="prix" label="" placeholder="Prix" required
                                   wire:model.defer="prix"></x-basecore::inputs.number>
    </div>

    <div class="px-2 pt-2">
        <button wire:click="send" class="btn btn-primary ">Envoyer</button>
    </div>


    <div>

        <table class="divide-y divide-gray-200 w-full mt-4">
            <thead class="bg-gray-200">
            <tr>
                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider">
                    Devis ID
                </th>
                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider">
                    Fournisseur
                </th>
                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider">
                    Prix
                </th>
                <th scope="col" class=" text-xs font-medium text-gray-500 uppercase tracking-wider">

                </th>

            </tr>
            </thead>
            <tbody>
            <!-- Odd row -->
            @foreach($dossier->devis as $devi)
                @foreach($devi->fournisseurs as $fourni)
                    <tr class="@if($fourni->pivot->validate) bg-green-500 @else bg-white  @endif">
                        <td class="py-4 whitespace-nowrap text-sm font-medium text-center">
                            {{ $devi->ref }}
                        </td>
                        <td class="py-4 text-sm text-center">

                            {{ $fourni->formatName }}
                        </td>
                        <td class="py-4 whitespace-nowrap text-sm text-center">
                            {{ $fourni->pivot->prix }}
                        </td>
                        <td class="whitespace-nowrap text-sm text-right">
                      <span class="flex flex-row justify-center">
                         <span
                             wire:click="delete({{ $devi->id }}, {{ $fourni->id }})"
                             class="cursor-pointer"
                             title="Supprimer"
                         >@icon('delete', 20, 'mr-2')</span>
                         <span
                             wire:click="validateDemande({{ $devi->id }}, {{ $fourni->id }})"
                             class="cursor-pointer"
                             title="Valider la demande fournisseur"
                         >@icon('check', 20, 'mr-2')
                         </span>
                      </span>
                        </td>
                    </tr>
                @endforeach
            @endforeach

            </tbody>
        </table>
    </div>


</div>
