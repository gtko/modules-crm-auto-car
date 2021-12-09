@props([
   'param',
   'model'
])

<x-basecore::inputs.group>
    <x-basecore::inputs.number
        name="name"
        label="Déclencher le rappel dans combien de temps en heures ?"
        wire:model="{{$model}}"
        required="required"
    />
</x-basecore::inputs.group>
