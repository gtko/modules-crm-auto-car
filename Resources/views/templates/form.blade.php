@php $editing = isset($template) @endphp


<div>
    <x-corecrm::mentionify.assets/>
    <x-corecrm::mentionify.wrapper :variableData="$variableData" class="w-full">
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
            <x-basecore::inputs.text
                name="subject"
                label="Sujet"
                value="{{ old('subject', ($editing ? $template->subject : '')) }}"
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
                :variableData="$variableData"
            ></x-basecore::inputs.wysiwyg>
        </x-basecore::inputs.group>
    </x-corecrm::mentionify.wrapper>
</div>
