@php $editing = isset($brand) @endphp

<div class="flex flex-wrap">
    <x-basecore::inputs.group class="w-full">
        <x-basecore::inputs.text
            name="label"
            label="Label"
            value="{{ old('label', ($editing ? $brand->label : '')) }}"
            maxlength="255"
            required="required"
        />
    </x-basecore::inputs.group>
</div>
