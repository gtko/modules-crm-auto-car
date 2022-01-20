<div>
    <div class="p-5 border-t border-gray-200 dark:border-dark-5">

        <div class="mb-2 space-y-1">
            @foreach($tagsDossier as $tagDossier)
                <div class="group cursor-pointer flex items-center hover:bg-red-600 hover:text-white justify-between bg-blue-400 text-white mr-1 px-2 py-1 rounded" wire:click="deleteTag({{$tagDossier->id}})">
                    <span class="whitespace-nowrap">{{$tagDossier->label}}</span>
                    <span class="ml-1" >
                       @icon('delete', 14)
                    </span>
                </div>

            @endforeach
        </div>

        <div class="flex w-full items-center ">
            <x-basecore::tom-select
                name="tagSelect"
                class="flex-grow"
                :collection="$tags"
                label="label"
                placeholder="Selectionner le(s) tag(s)"
            />
            <button class="btn-sm btn btn-primary ml-2" wire:click="addTag()">Ajouter</button>
        </div>

    </div>
</div>
