<div class="box mt-5 p-2">


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
        <x-basecore::inputs.select name="devi_id" label="" required="required" wire:model="devi_id">
            <option selected="selected">Devis</option>
            @foreach($this->devis as $devi)
                <option
                    value="{{ $devi->id}}">{{ $devi->ref }}</option>
            @endforeach
        </x-basecore::inputs.select>
    </div>
    <div class="px-2 pt-2">
        <x-basecore::tom-select
            name="fournisseur_id"
            :collection="$fournisseurs"
            label="formatName"
            placeholder="Fournisseurs"
        />
        <h2>Ou</h2>
        <x-basecore::tom-select
            name="tag_id"
            :collection="$tags"
            label="name"
            placeholder="Catégories"
        />
    </div>
    <div class="px-2 pt-2 flex justify-between items-center">
        <button wire:click="send" class="btn btn-primary ">Envoyer</button>

        <x-basecore::loading-replace wire:target="createWithoutSend">
            <button wire:click="createWithoutSend" class="btn btn-primary ">Créer sans envoyer</button>
        </x-basecore::loading-replace>
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
                    <livewire:crmautocar::block-fournisseur-item :key="$devi->id.'_'.$fourni->id" :devis="$devi" :fournisseur="$fourni"/>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>
</div>
