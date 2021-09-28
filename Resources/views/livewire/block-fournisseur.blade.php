<div class="intro-y box mt-5">
    <div class="flex justify-start items-center p-4">
        <span>@icon('creditCard', 30, 'mr-2')</span>
        <span class="text-lg">Demande Fournisseur</span>
    </div>
    <hr>
    <x-basecore::inputs.select name="devi_id" label="" required="required">
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Devis</option>
        @foreach($dossier->devis as $devi)
            <option
                value="{{ $devi->id}}">{{ $devi->ref }}</option>
        @endforeach
    </x-basecore::inputs.select>

    <x-basecore::inputs.select name="fournisseur_id" label="" required="required">
        <option disabled {{ empty($selected) ? 'selected' : '' }}>Fournisseur</option>
        @foreach($fournisseurs as $fourni)
            <option
                value="{{ $fourni->id}}">{{ $fourni->personne->firstname . ' ' . $fourni->personne->lastname }}</option>
        @endforeach
    </x-basecore::inputs.select>

    <button wire:click="send">Envoyer</button>

</div>
