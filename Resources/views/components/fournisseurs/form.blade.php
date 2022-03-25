@props([
    'fournisseur' => null,
    'tags' => [],
    'editing' => false
])

<x-basecore::inputs.group class="w-full">
    <x-basecore::inputs.checkbox
        name="enabled"
        label="Activé"
        :checked="old('enabled', ($editing ? ($fournisseur->enabled ?? true) : true))"
        maxlength="255"
        :required="!$editing"
    />
</x-basecore::inputs.group>
<div class="grid grid-cols-2">
<x-basecore::inputs.group class="w-full">
    <x-basecore::inputs.text
        name="company"
        label="Société"
        value="{{ old('company', ($editing ? $fournisseur->company : '')) }}"
        maxlength="255"
    />
</x-basecore::inputs.group>
<x-basecore::inputs.group class="w-full">
    <x-basecore::inputs.text
        name="astreinte"
        label="N° astreinte"
        value="{{ old('company', ($editing ? $fournisseur->astreinte : '')) }}"
        maxlength="255"
    />
</x-basecore::inputs.group>
</div>
<x-basecore::personne.form :disabled-fields="['date_birth', 'gender']"
                           :personne="$fournisseur" :editing="$editing"/>



<x-basecore::inputs.group>
    <label>Catégories du fournisseur</label>
    <x-basecore::tom-select
        name="tag_ids"
        :collection="$tags"
        label="name"
        id="name"
        :selected="old('tag_ids', ($editing ? $fournisseur->tagfournisseurs->pluck('name')->toArray() : []))"
        placeholder="Tags"
        :create="true"
        :livewire="false"
    />
</x-basecore::inputs.group>
