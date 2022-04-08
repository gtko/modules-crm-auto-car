
    <div class="flex flex-wrap">
        <div class="w-full">

            <div class="grid grid-cols-2">
                <x-basecore::inputs.group>
                    <x-basecore::inputs.text
                        name="company"
                        label=" Nom de société"
                        value="{{ old('company', ($editing ? $personne->company : ''))}}"
                        maxlength="255"
                    />
                </x-basecore::inputs.group>
                <x-basecore::inputs.group>
                    <x-basecore::inputs.text
                        name="firstname"
                        label="Prénom"
                        value="{{ old('firstname', ($editing ? $personne->firstName : '')) }}"
                        maxlength="255"
                        required="required"
                    />
                </x-basecore::inputs.group>
                <x-basecore::inputs.group>
                    <x-basecore::inputs.text
                        name="lastname"
                        label="Nom"
                        value="{{ old('lastname', ($editing ? $personne->lastName : '')) }}"
                        maxlength="255"
                    />
                </x-basecore::inputs.group>

                <x-basecore::inputs.group class="">
                    <x-basecore::inputs.select name="gender" label="Genre">
                        @php $selected = old('gender', ($editing ? $personne->gender : 'male')) @endphp
                        <option value="male" {{ $selected == 'male' ? 'selected' : '' }} >Monsieur</option>
                        <option value="female" {{ $selected == 'female' ? 'selected' : '' }} >Madame</option>
                    </x-basecore::inputs.select>
                </x-basecore::inputs.group>
                <x-basecore::inputs.group>
                    <x-basecore::inputs.text
                        name="address"
                        label="Adresse"
                        value="{{ old('address', ($editing ? $personne->address : ''))}}"
                        maxlength="255"
                    />
                </x-basecore::inputs.group>
                <x-basecore::inputs.group>
                    <x-basecore::inputs.text
                        name="city"
                        label="Ville"
                        value="{{ old('city', ($editing ? $personne->city : '')) }}"
                        maxlength="255"
                    />
                </x-basecore::inputs.group>
                <x-basecore::inputs.group>
                    <x-basecore::inputs.text
                        name="code_zip"
                        label="Code postal"
                        value="{{ old('code_zip', ($editing ? $personne->codeZip : '')) }}"
                        maxlength="255"
                    />
                </x-basecore::inputs.group>
                <x-basecore::inputs.group>
                    <x-basecore::inputs.select name="country_id" label="Pays" required>
                        @php $selected = old('country_id', ($editing ? $personne->personne->address?->country_id : '150')) @endphp
                        <option disabled {{ empty($selected) ? 'selected' : '' }}>Choisissez votre pays</option>
                        @foreach($countries as $country)
                            <option
                                value="{{ $country->id }}" {{ $selected == $country->id ? 'selected' : '' }} >{{ $country->name }}</option>
                        @endforeach
                    </x-basecore::inputs.select>
                </x-basecore::inputs.group>

                <div class="col-span-2 grid grid-cols-2">
                <x-basecore::list-inputs name="phones"
                                         :btn="'Ajouter un téléphone'"
                                         :items="old('phone',($editing ? $personne->personne->phones->pluck('phone')->toArray() : []))">
                    <x-basecore::inputs.group class="w-full">
                        <x-basecore::inputs.text
                            name="phone[]"
                            label="Téléphone"
                            x-model="items[index]"
                            maxlength="255"/>
                    </x-basecore::inputs.group>
                </x-basecore::list-inputs>

                <x-basecore::list-inputs name="emails"
                                         :btn="'Ajouter un mail'"
                                         :items="old('email',($editing ? $personne->personne->emails->pluck('email')->toArray() : []))">
                    <x-basecore::inputs.group class="w-full">
                        <x-basecore::inputs.email
                            name="email[]"
                            label="Email"
                            x-model="items[index]"
                            maxlength="255"
                        />
                    </x-basecore::inputs.group>
                </x-basecore::list-inputs>
                </div>
            </div>
        </div>
    </div>



    <div class="mt-5 px-2 flex justify-between">
       <div>
           {{$slot}}
       </div>
        <x-basecore::button type="submit">
            <i class="mr-1 icon ion-md-save"></i>
            @lang('basecore::crud.common.update')
        </x-basecore::button>
    </div>
