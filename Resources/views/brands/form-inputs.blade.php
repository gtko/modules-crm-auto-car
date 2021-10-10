@php $editing = isset($brand) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="label"
            label="Label"
            value="{{ old('label', ($editing ? $brand->label : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
