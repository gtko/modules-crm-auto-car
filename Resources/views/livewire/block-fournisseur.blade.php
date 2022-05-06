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
    @if(!$add)
    <div class="px-2 pt-2">
        <x-basecore::inputs.select name="devi_id" label="" required="required" wire:model="devi_id">
            <option selected="selected">Devis</option>
            @foreach($devis ?? [] as $devi)
                <option
                    value="{{ $devi->id}}">
                    {{ $devi->ref }}
                    @if($devi->validate)
                        - (validé)
                    @endif
                </option>
            @endforeach
        </x-basecore::inputs.select>
    </div>
    <div class="px-2 pt-2">
        <x-basecore::tom-select
            name="fournisseur_id"
            :max-item="99"
            :collection="$fournisseurs"
            label="company"
            placeholder="Fournisseurs"
        />
        <h2>Ou</h2>
        <x-basecore::tom-select
            name="tag_id"
            :collection="$tags"
            label="name"
            max-item="99"
            placeholder="Catégories"
        />
    </div>
            <div class="px-2 pt-2 flex justify-between items-center">
                <button wire:click="send" class="btn btn-primary ">Envoyer</button>
                <button wire:click="newFournisseur" class="btn btn-secondary">Nouveau</button>
                <x-basecore::loading-replace wire:target="createWithoutSend">
                    <button wire:click="createWithoutSend" class="btn btn-primary ">Créer sans envoyer</button>
                </x-basecore::loading-replace>
            </div>
            <div>
                <table class="divide-y divide-gray-200 w-full mt-4">
                    <thead class="bg-gray-200">
                    <tr>
                        <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider">
                            #
                        </th>
                        <th scope="col" class="py-3  text-xs font-medium uppercase tracking-wider">
                            Ref
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
                    @foreach($demandeFournisseurs as $demande)
                            <livewire:crmautocar::block-fournisseur-item :key="$demande->id" :demande="$demande"/>
                    @endforeach
                    </tbody>
                </table>
            </div>
    @else
        <div>
            <x-basecore::inputs.text name="company" label="Société" wire:model="add_company" />

            <x-basecore::inputs.text name="firstname" label="Prénom du contact" wire:model="add_firstname" />
            <x-basecore::inputs.text name="lastname" label="Nom du contact" wire:model="add_lastname" />
            <x-basecore::inputs.email name="email" label="Email" wire:model="add_email" />
            <x-basecore::inputs.text name="phone" label="Téléphone" wire:model="add_phone" />
            <div class="px-2 pt-2 flex justify-between items-center">
                <button wire:click="annulerAdd" class="btn btn-secondary ">Annuler</button>
                <button wire:click="createFournisseur" class="btn btn-primary ">Créer</button>
            </div>
        </div>
    @endif



</div>
