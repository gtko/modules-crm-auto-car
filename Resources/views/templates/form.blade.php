@php $editing = isset($template) @endphp


<div class="flex flex-wrap">
    <x-basecore::inputs.group class="w-full">
        <x-basecore::inputs.text
            name="title"
            label="Nom"
            value="{{ old('name', ($editing ? $template->title : '')) }}"
            maxlength="255"
            required
        ></x-basecore::inputs.text>
    </x-basecore::inputs.group>
    <x-basecore::inputs.group class="w-full">
        <x-basecore::inputs.wysiwyg
            name="content"
            label="Template"
            value="{{ old('content', ($editing ? $template->content : '')) }}"
            required
            :livewire="false"
        ></x-basecore::inputs.wysiwyg>
    </x-basecore::inputs.group>
</div>
