<div>

    <style>
        html, body {
            background:white;
        }
    </style>

    <div class="flex flex-col justify-between w-full h-full h-screen bg-white" style="font-family: 'Lato', sans-serif;">
        <div>
            <x-crmautocar::devis-client.header class="px-4 py-4 shadow"/>
            <div
                class="px-4 pt-4 pb-5 mx-auto bg-gray-200 lg:px-12 max-w-7xl sm:px-6 lg:px-8 lg:grid lg:grid-cols-3 lg:gap-4 ">
                <div class="flex flex-col print-col-span-3 lg:col-span-2">


                    @if($waiting)
                        <div class="p-4 mb-5 space-y-6 text-base text-white bg-green-600">
                            Vos informations ont été prises en compte et sont en attente de validation par nos équipes.<br>
                            Si vous avez des modifications à apporter, vous pouvez modifier le formulaire suivant dès maintenant.<br>
                            <br>
                            Si vous avez des modifications supplémentaires à apporter merci de contacter notre service client
                            <br>
                            Merci, l'Equipe de Centale Autocar.
                        </div>
                    @endif
                    @foreach(($devis->data['trajets'] ?? []) as $idTrajet => $trajet)
                    <div class="grid p-4 mb-4 bg-white border border-gray-400 notcut justify-items-stretch">
                        <div class="mb-4">
                            <h5 class="pl-2 my-2 text-2xl font-bold">Informations sur votre voyage @if($multiple) {{$idTrajet+1}} @endif</h5>
                            <hr class="mb-3 text-bleu">
                            <h5 class="pl-2 my-2 text-xl font-bold">
                                Aller
                                <sm class="ml-2 text-sm text-red-600">(Merci de préciser l'adresse exacte)</sm>
                            </h5>
                            <div class="grid grid-cols-2">
                                <x-basecore::inputs.group class="w-full">
                                    <x-basecore::inputs.datetime label="Date de départ" name="validate.{{$idTrajet}}.aller_date_depart"
                                                                 wire:model="validate.{{$idTrajet}}.aller_date_depart"
                                                                 placeholder="Date de départ"/>
                                </x-basecore::inputs.group>
                                <x-basecore::inputs.group class="w-full">
                                    <x-basecore::inputs.basic label="Nombre de passagers" name="validate.{{$idTrajet}}.aller_pax" wire:model.lazy="validate.{{$idTrajet}}.aller_pax" placeholder="Nombre de passagers"/>
                                </x-basecore::inputs.group>

                                <x-basecore::inputs.group class="col-span-2">
                                    <x-basecore::inputs.basic class='addressmap'
                                                              data-trajet="{{$idTrajet}}" data-name="addresse_ramassage"
                                                              label="Adresse de prise en charge" name="validate.{{$idTrajet}}.addresse_ramassage"  wire:model.lazy="validate.{{$idTrajet}}.addresse_ramassage"/>
                                </x-basecore::inputs.group>
                                <x-basecore::inputs.group class="col-span-2">
                                    <x-basecore::inputs.basic class='addressmap' data-trajet="{{$idTrajet}}" data-name="addresse_destination" label="Adresse de destination" name="validate.{{$idTrajet}}.addresse_destination"  wire:model.lazy="validate.{{$idTrajet}}.addresse_destination"/>
                                </x-basecore::inputs.group>

                            </div>
                            <hr class="my-3 text-bleu">
                            <h5 class="pl-2 my-2 text-xl font-bold">Contact sur place</h5>
                            <div class="grid grid-cols-2">
                                <x-basecore::inputs.group>
                                    <x-basecore::inputs.basic label="Nom" name="validate.{{$idTrajet}}.contact_nom"
                                                              wire:model.lazy="validate.{{$idTrajet}}.contact_nom"/>
                                </x-basecore::inputs.group>
                                <x-basecore::inputs.group>
                                    <x-basecore::inputs.basic label="Prénom" name="validate.{{$idTrajet}}.contact_prenom"
                                                              wire:model.lazy="validate.{{$idTrajet}}.contact_prenom"/>
                                </x-basecore::inputs.group>
                                <x-basecore::inputs.group>
                                    <x-basecore::inputs.basic label="N° de portable 1" name="validate.{{$idTrajet}}.tel_1"
                                                              wire:model.lazy="validate.{{$idTrajet}}.tel_1"/>
                                </x-basecore::inputs.group>
                                <x-basecore::inputs.group>
                                    <x-basecore::inputs.basic label="N° de portable 2" name="validate.{{$idTrajet}}.tel_2"
                                                              wire:model.lazy="validate.{{$idTrajet}}.tel_2"/>
                                </x-basecore::inputs.group>


                            </div>

                            <hr class="my-3 text-bleu">
                            <h5 class="pl-2 my-2 text-xl font-bold">Informations complémentaire</h5>
                            <x-basecore::inputs.group>
                                <x-basecore::inputs.textarea class='h-48' label="détails" name="validate.{{$idTrajet}}.information_complementaire"
                                                             wire:model.lazy="validate.{{$idTrajet}}.information_complementaire"
                                                             placeholder="Des détails sur les choses lourdes à transporter (Valises-Malles etc).
En cas de prise en charge ou d'arrivée au sein d'un aéroport ou d'une gare, nous vous remercions de nous indiquer les numéros de vols, numéros de trains ainsi que les terminaux concernés.  "
                                />
                            </x-basecore::inputs.group>
                        </div>
                    </div>
                    @endforeach
                        @if($devis->data['validated'] ?? false)
                            <div class="flex items-center justify-center w-full my-5">
                                <span class="px-3 py-2 text-white bg-green-600 rounded shadow">
                                    Information enregistrée
                                </span>
                            </div>
                        @else
                            <div class="flex items-center justify-center w-full my-5">
                                <button class="btn btn-primary" wire:click="store">
                                    Enregistrer mes informations
                                </button>
                            </div>
                        @endif


                </div>
                <div class="flex flex-col col-span-1 no-print">
                    <x-crmautocar::devis-client.client-information
                        :devis="$devis"
                        class="my-6 lg:order-1"
                    />

                    <x-crmautocar::devis-client.conseiller
                        :devis="$devis"
                        class="p-4 mb-6 bg-white border border-2 border-gray-400 lg:order-3"
                    />

                    <livewire:crmautocar::devis-client.recap-devis
                        :devis="$devis"
                        :brand="$brand"
                        :class="'bg-white p-4 grid justify-items-stretch border border-2 border-gray-400 lg:order-2 mb-4'"
                        :sidebar="true"/>
                </div>
            </div>
        </div>
        <x-crmautocar::devis-client.footer class="h-32"/>
    </div>
    <script>
        function initInput(selecteur) {
            let addressFields;
            addressFields = document.querySelectorAll(selecteur);
            for (let addressField of addressFields) {
                let autocomplete;
                autocomplete = new google.maps.places.Autocomplete(addressField, {
                    componentRestrictions: {},
                    fields: ["formatted_address", "geometry"],
                });
                autocomplete.addListener("place_changed", () => {
                    const place = autocomplete.getPlace()
                    addressField.value = place.formatted_address
                    @this.emit('devis:update-address', {
                        'id' : addressField.getAttribute('data-trajet'),
                        'name': addressField.getAttribute('data-name'),
                        'format': place.formatted_address,
                    })
                });
            }
        }

        function initAutocomplete() {
            initInput('.addressmap')
        }
    </script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_API_KEY') }}=places&v=weekly"
    ></script>
</div>
