<div class="intro-y box mt-5 p-2">
    <div class="flex justify-start items-center p-4">
        @icon('phone', 30, 'mr-2')
        <span class="text-lg">Contact chauffeur</span>
    </div>

    <div class="px-2 pt-2">
        <x-basecore::inputs.select name="fournisseur_id" label="" required="required" wire:model="fournisseur_id">
            <option selected="selected">Fournisseur</option>
            @foreach($fournisseurs as $fournisseur)
                <option value="{{ $fournisseur->id }}">{{ $fournisseur->format_name }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </div>


    <div class="px-2 pt-2">
        <x-basecore::inputs.select name="devis_id" label="" required="required" wire:model="devis_id">
            <option selected="selected">Devis</option>
            @foreach($dossier->devis as $devis)
                <option value="{{ $devis->id }}">{{ $devis->ref }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </div>
    <div class="px-2 pt-2">
        <x-basecore::inputs.select name="devis_id" label="" required="required" wire:model="type_trajet">
            <option selected="selected">Type de trajet</option>
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


    <div>
        <table class="divide-y divide-gray-200 w-full mt-4">
            <thead class="bg-gray-200">
            <tr>
                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider text-xs">
                    Fournisseur
                </th>
                <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider text-xs">
                    Nom et prénom
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
