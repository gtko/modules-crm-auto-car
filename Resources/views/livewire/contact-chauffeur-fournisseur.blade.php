<div class="box mt-5 p-2">
    <div class="flex justify-start items-center p-4">
        @icon('phone', 30, 'mr-2')
        <span class="text-lg">Contact chauffeur</span>
    </div>

    <div class="px-2 pt-2">
        <x-basecore::inputs.select name="fournisseur" label="" required="required" wire:model="fournisseur">
            <option selected="selected">Fournisseur</option>
            @foreach($fournisseurs as $fournisseurSelect)
                <option value="{{ $fournisseurSelect->id }}">{{ $fournisseurSelect->format_name }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </div>


    <div class="px-2 pt-2">
        <x-basecore::inputs.select name="devis" label="" required="required" wire:model="devis">
            <option selected="selected" value="">Devis</option>
            @foreach($dossier->devis as $devisSelect)
                <option value="{{ $devisSelect->id }}">{{ $devisSelect->ref }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </div>

    @if($devis)
        @if($this->nbrTrajet > 1)
            <div class="px-2 pt-2">
                <x-basecore::inputs.select name="trajet" label="" required="required" wire:model="trajet">
                    <option selected="selected">trajet</option>
                    @for ($i = 0; $i < $this->nbrTrajet; $i++)
                        <option value="{{$i}}">Trajet {{ $i + 1 }}</option>
                    @endfor


                </x-basecore::inputs.select>
            </div>
        @endif
        <div class="px-2 pt-2">
            <x-basecore::inputs.select name="type_trajet" label="" required="required" wire:model="type_trajet">
                <option value='' selected="selected">Type de trajet</option>
                <option value="aller">Aller</option>
                <option value="retour">Retour</option>
                <option value="aller_retour">Aller / Retour</option>
            </x-basecore::inputs.select>
        </div>

        <div class="px-2 pt-2">
            <x-basecore::inputs.text name='name' wire:model="name" placeholder="Nom et prénom"/>
        </div>

        <div class="px-2 pt-2">
            <x-basecore::inputs.text name='phone' wire:model="phone" placeholder="Téléphone"/>
        </div>

            <div class="px-2 pt-2">
                <x-basecore::inputs.textarea name='commentaire' wire:model="commentaire" placeholder="Commentaire"/>
            </div>

        <div class="m-2">
            <x-basecore::loading-replace wire:target="store">
                <x-slot name="loader">
                    <button class="btn btn-primary" disabled>
                        @icon('spinner', 20, 'animate-spin mr-2') Sauvegarder
                    </button>
                </x-slot>
                <x-basecore::button wire:click="store">Sauvegarder</x-basecore::button>
            </x-basecore::loading-replace>

        </div>
    @endif

    <div>
        <table class="divide-y divide-gray-200 w-full mt-4">
            <thead class="bg-gray-200">
            <tr>
                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider text-xs">
                    Fournisseur
                </th>
                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider text-xs">
                    devis ref
                </th>
                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider text-xs">
                    Téléphone
                </th>
                <th scope="col" class=" text-xs font-medium text-gray-500 uppercase tracking-wider">
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($contacts as $contact)
                <livewire:crmautocar::contact-chauffeur-fournisseur-item :key="$contact->id" :contact="$contact"/>
            @endforeach
            </tbody>

        </table>
    </div>

</div>
