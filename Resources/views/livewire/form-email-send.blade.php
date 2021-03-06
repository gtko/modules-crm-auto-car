<div class="p-4" style="z-index: 900000;">

    <form method="POST" wire:submit.prevent="store" class="mt-5">

        <x-basecore::inputs.text name="subject" required="required" wire:model.defer="subjectMail" label="Sujet :" class="mb-4"/>
        <x-basecore::inputs.select name="template" required="required" wire:model="template" label="Template :" class="mb-4">
            <option selected="selected" value="">Template</option>
            @foreach($templates as $template)
                <option value="{{ $template->id }}">{{ $template->title }}</option>
            @endforeach
        </x-basecore::inputs.select>

        <x-basecore::inputs.wysiwyg name="content" label="" class="mb-4" :livewire="true"/>

        <x-basecore::button type="submit" class="my-3">Envoyer</x-basecore::button>
    </form>


</div>
