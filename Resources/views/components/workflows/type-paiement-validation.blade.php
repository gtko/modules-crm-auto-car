@props([
   'param',
   'model'
])
<x-basecore::inputs.group>
    <x-basecore::inputs.select
        name="name"
        label="{{$param->name()}}"
        wire:model="{{$model}}"
        required="required"
    >
        <option>Sélectionner un Type de paiement</option>
        <option value="carte">Carte bancaire</option>
        <option value="virement">Virement</option>
        <option value="cheque">Chèque</option>
    </x-basecore::inputs.select>
</x-basecore::inputs.group>
