<div>
    <hr class="mx-2">
    <div class="ml-4 mr-auto my-2">
        @foreach($tagsDossier as $tagDossier)
            <span class="bg-gray-600 text-white m-1 p-1 rounded">
               {{$tagDossier->label}}
                <span class="cursor-pointer ml-1" wire:click="deleteTag({{$tagDossier->id}})">X</span>
            </span>

        @endforeach
    </div>

    <div class="space-y-2 m-2">
        <x-basecore::tom-select
            name="tagSelect"
            :collection="$tags"
            label="label"
            placeholder="Selectionner le(s) tag(s)"
        />
        <button class="btn-sm btn btn-primary" wire:click="addTag()">Ajouter</button>
    </div>
</div>

