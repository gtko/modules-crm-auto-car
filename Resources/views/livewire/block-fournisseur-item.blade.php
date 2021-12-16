<tr class="@if($fourni->pivot->bpa) bg-blue-500 text-white @else @if($fourni->pivot->validate) bg-green-500 @else bg-white  @endif @endif">
    <td class="py-4 whitespace-nowrap text-sm font-medium text-center">
        {{ $devi->ref }}
    </td>
    <td class="py-4 text-sm text-center">

        {{ $fourni->formatName }}
    </td>
    <td class="py-4 whitespace-nowrap text-sm text-center">

        @if(!$fourni->pivot->validate && $this->editPrice)
            <input type="number" class="w-24" wire:model="price">
        @else
            {{ $fourni->pivot->prix }} €
        @endif

    </td>
    <td class="whitespace-nowrap text-sm text-right">
                      <span class="flex flex-row justify-center items-center space-x-0.5">
                          @if($this->editPrice)
                              <span
                                  wire:click="closePrice({{ $devi->id }}, {{ $fourni->id }})"
                                  class="cursor-pointer hover:text-red-600"
                                  title="annuler"
                              >@icon('close', null)
                             </span>
                              <span
                                  wire:click="savePrice({{ $devi->id }}, {{ $fourni->id }})"
                                  class="cursor-pointer  hover:text-green-600"
                                  title="Sauvegarder le prix"
                              >@icon('check', null)
                             </span>
                          @else
                              <span
                                  wire:click="delete({{ $devi->id }}, {{ $fourni->id }})"
                                  class="cursor-pointer  hover:text-red-600"
                                  title="Supprimer"
                              >@icon('delete', 20)</span>
                              @if($fourni->pivot->validate)
                                  @if(!$fourni->pivot->bpa)
                                  <span
                                      wire:click="bpa({{ $devi->id }}, {{ $fourni->id }})"
                                      class="cursor-pointer  hover:text-green-600"
                                      title="BPA reçu"
                                  >@icon('badgeCheck', null)
                                  </span>
                                  @endif
                             @else
                                  <span
                                      wire:click="editerPrice({{ $devi->id }}, {{ $fourni->id }})"
                                      class="cursor-pointer  hover:text-primary-1"
                                      title="editer le prix"
                                  >@icon('cash', null)
                                  </span>
                                  <span
                                      wire:click="validateDemande({{ $devi->id }}, {{ $fourni->id }})"
                                      class="cursor-pointer  hover:text-green-600"
                                      title="Valider la demande fournisseur"
                                  >@icon('checkCircle', 20, 'mr-2')
                                  </span>
                             @endif
                          @endif

                      </span>
    </td>
</tr>