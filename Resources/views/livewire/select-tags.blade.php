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
        <x-basecore::inputs.select name="tagSelect" wire:model="tagSelect">
            <option value="">Sélectionnez un tag</option>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}"> {{ $tag->label }}</option>
            @endforeach
        </x-basecore::inputs.select>
        <button class="btn-sm btn btn-primary" wire:click="addTag()">Ajouter</button>
    </div>

</div>

