<tr class="
@if($demande->isBPA()) bg-blue-500 text-white
    @else
    @if($demande->isValidate() ?? false) bg-green-500
    @elseif($demande->isRefused() ?? false) bg-red-500
    @elseif($demande->hasCancel() ?? false) bg-red-200
    @else bg-white
    @endif
@endif">
    @if($fourni->formatName ?? false)
        <td class="py-4 whitespace-nowrap text-sm font-medium text-center">
            {{ $demande->id }}
        </td>
        <td class="py-4 text-sm font-medium text-center">
            <div class="flex flex-col">
                <span>{{ $fourni->company }}</span>
                <small>{{ $devi->ref }}</small>
            </div>
        </td>
        <td class="py-4 whitespace-nowrap text-sm text-center">

            @if(!$demande->isValidate() && !$demande->isBPA())
                <div class="flex items-center space-x-2">
                <input type="number" class="w-20 text-sm" wire:model.lazy="price">
                    <x-basecore::loading-replace wire:target="savePrice">
                        <span
                            wire:click="savePrice"
                            class="cursor-pointer  hover:text-primary-1"
                            title="sauvegarder le prix"
                        >
                            @icon('cash', null)
                        </span>
                    </x-basecore::loading-replace>
                </div>
            @else
                {{ $demande->prix ?? '--'}} €
            @endif

        </td>
        <td class="whitespace-nowrap text-sm text-right">
            @if(!$demande->hasCancel())
                      <span class="flex flex-row justify-center items-center space-x-0.5">
                              <span
                                  wire:click="delete"
                                  class="cursor-pointer  hover:text-red-600"
                                  title="Supprimer"
                              >
                                      @icon('delete', 20)
                                  </span>
                              @if($demande->isValidate() || $demande->isBPA())
                                  @if(!$demande->isBPA())
                                      <span
                                          wire:click="bpa"
                                          class="cursor-pointer  hover:text-green-600"
                                          title="BPA reçu"
                                      >@icon('badgeCheck', null)
                                  </span>
                                  @endif
                              @else

                                  <span
                                      wire:click="validateDemande"
                                      class="cursor-pointer  hover:text-green-600"
                                      title="Valider la demande fournisseur"
                                  >@icon('checkCircle', 20,'')
                                  </span>

                                  @if(!$demande->isRefused())
                                      <span
                                          wire:click="refuseDemande"
                                          class="cursor-pointer  hover:text-red-600"
                                          title="Refuser la demande fournisseur"
                                      >@icon('close', 20, 'mr-2')
                                  </span>
                                  @endif
                              @endif
                      </span>
            @else
                <span class="flex flex-row justify-center items-center space-x-0.5">
                    <small class="px-2">Annulé</small>
                </span>
            @endif
        </td>
    @endif
</tr>
