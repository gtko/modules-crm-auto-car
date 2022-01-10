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
        <option>Sélectionner un solde</option>
        <option value="complet">Payé</option>
        <option value="partiel">Partiel</option>
        <option value="aucun">Aucun</option>
    </x-basecore::inputs.select>
</x-basecore::inputs.group>
