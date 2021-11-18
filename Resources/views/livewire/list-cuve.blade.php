<div class="mt-8">


    <div class="nav nav-tabs flex-row justify-center items-center space-x-8">
        <span class="py-4 flex items-center cursor-pointer @if($filtre == 'attente')  active @endif" wire:click="changeFiltre('attente')">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-mail w-4 h-4 mr-2">
                        <path
                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    En attente
        </span>
        <span class="py-4 flex items-center cursor-pointer @if($filtre == 'distribuer')  active @endif" wire:click="changeFiltre('distribuer')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-send w-4 h-4 mr-2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    Distribué
        </span>
        <span class="py-4 flex items-center cursor-pointer @if($filtre == 'corbeille')  active @endif" wire:click="changeFiltre('corbeille')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-trash w-4 h-4 mr-2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path
                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    Corbeille
        </span>
    </div>


    <div class="col-span-12 lg:col-span-9 xxl:col-span-10">

        <!-- BEGIN: Inbox Content -->
        <div class="intro-y inbox box mt-5">
            <div
                class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                <div class="flex flex-row">
                    <select wire:model="commercial" class="form-select form-select-sm">
                        <option value="">Commercial</option>
                        @foreach($commercials as $commercial)
                            <option value="{{$commercial->id}}"> {{ $commercial->formatName }}</option>
                        @endforeach
                    </select>
                    <span wire:click="attribuer"
                          class="bg-blue-600 p-2 w-32 text-center text-white rounded ml-2 cursor-pointer flex items-center justify-center">
                        Attribuer
                    </span>
                    <select wire:model="pipeline" class="form-select form-select ml-8">
                        <option value="">Pipeline</option>
                        @foreach($pipelines as $pipeline)
                            <option value="{{$pipeline->id}}"> {{ $pipeline->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center sm:ml-auto">


                    <div class="dark:text-gray-300">1 - 50 sur {{$total}}</div>
                    <a href="{{$prev}}" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-left w-4 h-4">
                            <polyline points="15 18 9 12 15 6"></polyline>
                        </svg>
                    </a>
                    <a href="{{$next}}" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-chevron-right w-4 h-4">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="overflow-x-auto sm:overflow-x-visible">

                <table class="table table--sm">
                    <thead>
                    <tr>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">
                            <input class="form-check-input flex-none" type="checkbox" wire:model="all" value="all">
                            Nom
                        </th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Source</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Email</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Téléphone</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Date de réception</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($dossiers as $dossier)
                        <livewire:crmautocar::element-list-cuve :dossier="$dossier" :key="$dossier->id" :filtre="$filtre"/>
                    @empty
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <button type="button"
                                class="relative block w-full  p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                 viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                            </svg>
                            <span class="mt-2 block text-sm font-medium text-gray-900">
                                Aucun dossier en attente
                            </span>
                        </button>
                    @endforelse

                    </tbody>
                </table>
            </div>
            <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-gray-600">
                @if($dossiers->first())
                    <div class="sm:ml-auto mt-2 sm:mt-0 dark:text-gray-300">Derniers
                        formulaire {{$dossiers->first()?->created_at->diffForHumans()}}</div>
                @endif
            </div>
        </div>
        <!-- END: Inbox Content -->
    </div>
</div>
