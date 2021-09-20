@php $editing = isset($template) @endphp


<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Nom"
            value="{{ old('name', ($editing ? $template->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="subject"
            label="Sujet"
            value="{{ old('subject', ($editing ? $template->subject : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>
    <x-inputs.group class="w-full">
        <x-inputs.wysiwyg
            name="content"
            label="Template"
            value="{{ old('content', ($editing ? $template->content : '')) }}"
            required
            :livewire="false"
        ></x-inputs.wysiwyg>
    </x-inputs.group>
</div>
