<div>
    @if($preview)

        <div style="max-height:100%;height:500px;">
            <iframe srcdoc="{{ $this->email_preview }}" class="w-full h-full"></iframe>
        </div>
        <div class="flex justify-end w-full items-center pt-4 space-x-2">
            <span wire:click="editer" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                   Editer l'email
            </span>
            <x-basecore::loading-replace>
                <x-slot name="loader">
                            <span class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                @icon('spinner', 20, 'animate-spin mr-2') Envoyer l'email
                            </span>
                </x-slot>
                <span wire:click="send" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                       Envoyer l'email
                </span>
            </x-basecore::loading-replace>
        </div>
    @else
        <x-corecrm::mentionify.assets/>
        <x-corecrm::mentionify.wrapper :variableData="$variableData" >
            <div>
                <x-basecore::inputs.basic label="sujet" name="email.subject" wire:model="email.subject"/>

                <x-basecore::inputs.select name="email.sender"  label='Expéditeur' wire:model="email.sender">
                    <option>noreply@crmautocar.com</option>
                    <option>commercial@crmautocar.com</option>
                    <option>noreply@locationautocar.com</option>
                </x-basecore::inputs.select>

                <x-basecore::inputs.basic label="CC" name="email.cc"  wire:model="email.cc"/>
                <x-basecore::inputs.basic label="CCI" name="email.cci"  wire:model="email.cci"/>


                <x-basecore::inputs.select name="email.model" label="Modèles d'email" wire:model="email.model">
                    @foreach($templates as $template)
                        <option value="{{$template->id}}">{{$template->title}}</option>
                    @endforeach
                </x-basecore::inputs.select>

                <x-basecore::inputs.wysiwyg label="message" name="email.body" :livewire="true" :variableData="$variableData"/>


                <x-basecore::inputs.basic type='file' multiple="true" label="Pièces jointes" name="email.attachments"  wire:model="email.attachments"/>

                <x-basecore::loading-replace>
                    <x-slot name="loader">
                                <span class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    @icon('spinner', 20, 'animate-spin mr-2') Valider l'email
                                </span>
                    </x-slot>
                    <span wire:click="preview" class="cursor-pointer inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                           Valider l'email
                    </span>
                </x-basecore::loading-replace>
            </div>
        </x-corecrm::mentionify.wrapper>
    @endif
</div>
