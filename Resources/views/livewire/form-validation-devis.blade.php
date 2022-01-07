<div class="p-4" style="z-index: 900000;">
    <div class="text-bleu font-bold text-3xl my-2 text-center w-full">Validation devis</div>
    <hr class="text-bleu mb-3">
    <div class="grid grid-cols-2 gap-8">
        <div class="col-start-1">
            @foreach($this->initiale as $index => $trajetValidate)
                <div class="text-bleu my-2 font-bold text-xl mt-4">devis initiale {{$index + 1}}</div>
                <x-basecore::inputs.datetime
                    class="form-control-sm"
                    label="Date de départ"
                    name="initiale.{{$index}}.aller_date_depart"
                    wire:model.defer="initiale.{{$index}}.aller_date_depart"
                    placeholder="Date de départ"
                    disabled
                />
                <x-basecore::inputs.number
                    class="form-control-sm"
                    label="Nombre de passager départ"
                    name="initiale.{{$index}}.aller_pax"
                    wire:model="initiale.{{$index}}.aller_pax"
                    placeholder="Nombre de passager départ"
                    disabled
                />
                <x-basecore::inputs.text
                    class="form-control-sm"
                    label="Adresse de prise en charge"
                    name="initiale.{{$index}}.addresse_ramassage"
                    wire:model="initiale.{{$index}}.addresse_ramassage"
                    placeholder="Adresse de prise en charge"
                    disabled
                />
                <x-basecore::inputs.datetime
                    class="form-control-sm"
                    label="Date de retour"
                    name="initiale.{{$index}}.aller_date_depart"
                    wire:model.defer="initiale.{{$index}}.aller_date_depart"
                    placeholder="Date de retour"
                    disabled
                />
                <x-basecore::inputs.number
                    class="form-control-sm"
                    label="Nombre de passager retour"
                    name="initiale.{{$index}}.retour_pax"
                    wire:model="initiale.{{$index}}.retour_pax"
                    placeholder="Nombre de passager retour"
                    disabled
                />
                <x-basecore::inputs.text
                    class="form-control-sm"
                    label="Adresse de ramassage"
                    name="initiale.{{$index}}.addresse_ramassage"
                    wire:model="initiale.{{$index}}.addresse_ramassage"
                    placeholder="Adresse de ramassage"
                    disabled
                />

                <x-basecore::inputs.text
                    class="form-control-sm"
                    label="Nom"
                    name="initiale.{{$index}}.contact_nom"
                    wire:model="initiale.{{$index}}.contact_nom"
                    placeholder="Nom du contact"
                    disabled
                />
                <x-basecore::inputs.text
                    class="form-control-sm"
                    label="Prenom du contact"
                    name="initiale.{{$index}}.contact_prenom"
                    wire:model="initiale.{{$index}}.contact_prenom"
                    placeholder="Prenom du contact"
                    disabled
                />
                <x-basecore::inputs.text
                    class="form-control-sm"
                    label="Nom du contact"
                    name="initiale.{{$index}}.tel_1"
                    wire:model="initiale.{{$index}}.tel_1"
                    placeholder="Tel 1 du contact"
                    disabled
                />
                <x-basecore::inputs.text
                    class="form-control-sm"
                    label="Adresse de ramassage"
                    name="initiale.{{$index}}.tel_2"
                    wire:model="initiale.{{$index}}.tel_2"
                    placeholder="Tel 2 du contact"
                    disabled
                />
                <x-basecore::inputs.textarea
                    class='h-16' label="détails"
                    name="initiale.{{$index}}.information_complementaire"
                    wire:model="initiale.{{$index}}.information_complementaire"
                    placeholder="Information complémentaire"
                    disabled
                />

            @endforeach
        </div>

        <div class="col-start-2">
            @foreach($this->validate as $index => $trajetValidate)
                <div class="text-bleu my-2 font-bold text-xl mt-4">Modification devis {{$index + 1}}</div>
                <x-basecore::inputs.datetime
                    :class="'form-control-sm '.((!$delta[$index]['aller_date_depart'])?'bg-red-200':'')"
                    label="Date de départ"
                    name="validate.{{$index}}.aller_date_depart"
                    wire:model.defer="validate.{{$index}}.aller_date_depart"
                    placeholder="Date de départ"
                />
                <x-basecore::inputs.number
                    :class="'form-control-sm '.((!$delta[$index]['aller_pax'])?'bg-red-200':'')"
                    label="Nombre de passager départ"
                    name="validate.{{$index}}.aller_pax"
                    wire:model="validate.{{$index}}.aller_pax"
                    placeholder="Nombre de passager départ"
                />
                <x-basecore::inputs.text
                    :class="'form-control-sm '.((!$delta[$index]['addresse_ramassage'])?'bg-red-200':'')"
                    label="Adresse de prise en charge"
                    name="validate.{{$index}}.addresse_ramassage"
                    wire:model="validate.{{$index}}.addresse_ramassage"
                    placeholder="Adresse de prise en charge"
                />
                <x-basecore::inputs.datetime
                    :class="'form-control-sm '.((!$delta[$index]['retour_date_depart'])?'bg-red-200':'')"
                    label="Date de retour"
                    name="validate.{{$index}}.retour_date_depart"
                    wire:model.defer="validate.{{$index}}.retour_date_depart"
                    placeholder="Date de retour"
                />
                <x-basecore::inputs.number
                    :class="'form-control-sm '.((!$delta[$index]['retour_pax'])?'bg-red-200':'')"
                    label="Nombre de passager retour"
                    name="validate.{{$index}}.retour_pax"
                    wire:model="validate.{{$index}}.retour_pax"
                    placeholder="Nombre de passager retour"
                />
                <x-basecore::inputs.text
                    :class="'form-control-sm '.((!$delta[$index]['addresse_destination'])?'bg-red-200':'')"
                    label="Adresse de ramassage"
                    name="validate.{{$index}}.addresse_destination"
                    wire:model="validate.{{$index}}.addresse_destination"
                    placeholder="Adresse de ramassage"
                />

                <x-basecore::inputs.text
                    :class="'form-control-sm '.((!$delta[$index]['contact_nom'])?'bg-red-200':'')"
                    label="Nom"
                    name="validate.{{$index}}.contact_nom"
                    wire:model="validate.{{$index}}.contact_nom"
                    placeholder="Nom du contact"
                />
                <x-basecore::inputs.text
                    :class="'form-control-sm '.((!$delta[$index]['contact_prenom'])?'bg-red-200':'')"
                    label="Prenom du contact"
                    name="validate.{{$index}}.contact_prenom"
                    wire:model="validate.{{$index}}.contact_prenom"
                    placeholder="Prenom du contact"
                />
                <x-basecore::inputs.text
                    :class="'form-control-sm '.((!$delta[$index]['tel_1'])?'bg-red-200':'')"
                    label="Nom du contact"
                    name="validate.{{$index}}.tel_1"
                    wire:model="validate.{{$index}}.tel_1"
                    placeholder="Tel 1 du contact"
                />
                <x-basecore::inputs.text
                    :class="'form-control-sm '.((!$delta[$index]['tel_2'])?'bg-red-200':'')"
                    label="Adresse de ramassage"
                    name="validate.{{$index}}.tel_2"
                    wire:model="validate.{{$index}}.tel_2"
                    placeholder="Tel 2 du contact"
                />
                <x-basecore::inputs.textarea
                    :class="'h-16 '.((!$delta[$index]['information_complementaire'])?'bg-red-200':'')"
                    label="détails"
                    name="validate.{{$index}}.information_complementaire"
                    wire:model="validate.{{$index}}.information_complementaire"
                    placeholder="Information complémentaire"
                />

            @endforeach
        </div>
    </div>

    <div class="my-4 w-full flex flex-row justify-center space-x-6">
        <x-basecore::button name="Annuler" class="bg-red-600 border-2 border-red-700" wire:click="close()">Annuler
        </x-basecore::button>
        <x-basecore::button name="Valider" class="bg-green-600 border-2 border-green-700" wire:click="valider()">Valider les infos
        </x-basecore::button>
    </div>

</div>
