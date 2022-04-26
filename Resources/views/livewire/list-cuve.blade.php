<div class="mt-8">


    <div class="nav nav-tabs flex-row justify-center items-center space-x-8">
        <span wire:key="en_attente" class="py-4 flex items-center cursor-pointer @if($filtre == 'attente')  active @endif"
              wire:click="changeFiltre('attente')">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-mail w-4 h-4 mr-2">
                        <path
                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    En attente
        </span>
        <span wire:key="distribuer"  class="py-4 flex items-center cursor-pointer @if($filtre == 'distribuer')  active @endif"
              wire:click="changeFiltre('distribuer')">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                 class="feather feather-send w-4 h-4 mr-2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    Distribué
        </span>
        <span wire:key="corbeille" class="py-4 flex items-center cursor-pointer @if($filtre == 'corbeille')  active @endif"
              wire:click="changeFiltre('corbeille')">
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
        <div class="inbox box mt-5">
            <div
                class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                <div class="flex flex-row">
                    <select wire:model="commercial" class="form-select form-select-sm">
                        <option value="">Commercial</option>
                        @foreach($commercials as $commercial)
                            @if ($commercial->id != 1)
                                <livewire:crmautocar::list-cuve-commercial-detail
                                    wire:key="{{$commercial->id}}"
                                    :commercial="$commercial"
                                />
                            @endif
`
                        @endforeach
                    </select>
                    <span wire:click="attribuer"
                          class="bg-blue-600 p-2 w-32 text-center text-white rounded ml-2 cursor-pointer flex items-center justify-center">
                        Attribuer
                    </span>

                </div>
                <div class="flex justify-start items-center ml-3">
                    @if(count($selection) > 0)
                        Vous avez sélectionné {{count($selection)}} dossier(s)
                    @endif
                </div>


                    <div wire:key='link_nav'  class="flex items-center sm:ml-auto">
                        <div class="dark:text-gray-300">{{($dossiers->perPage() * $dossiers->currentPage()) - $dossiers->perPage()}} - {{($dossiers->perPage() * $dossiers->currentPage())}} sur {{$dossiers->total()}}</div>
                        @if($dossiers->lastPage() > 1)
                        <a wire:key='previous' href="{{$dossiers->appends(request()->input())->previousPageUrl()}}"
                           class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-left w-4 h-4">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </a>
                        <a wire:key='next'  href="{{$dossiers->appends(request()->input())->nextPageUrl()}}"
                           class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                 fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" class="feather feather-chevron-right w-4 h-4">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </a>
                        @endif
                    </div>
            </div>
            <div class="overflow-x-scroll sm:overflow-x-scroll">

                @if($dossiers->count() > 0)
                    <table class="table table--sm">
                        <thead>
                        <tr>
                            <x-crmautocar::colsort wire:click="sort('format_name')"
                                                   class="border-b-2 dark:border-dark-5 w-24 text-xs py-2"
                                                   :active="$order === 'format_name'"
                                                   :sort="$direction"
                            >
                                <input class="form-check-input flex-none" type="checkbox" wire:model="all" value="all">
                                Nom
                            </x-crmautocar::colsort>

                            <x-crmautocar::colsort wire:click="sort('source')"
                                                   class="border-b-2 dark:border-dark-5 w-24 text-xs  py-2"
                                                   :active="$order === 'source'"
                                                   :sort="$direction"
                            >
                                Source
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('email')"
                                                   class="border-b-2 dark:border-dark-5 w-24 text-xs  py-2"
                                                   :active="$order === 'email'"
                                                   :sort="$direction"
                            >
                                Email
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('commercial')"
                                                   class="border-b-2 dark:border-dark-5 w-24 text-xs py-2"
                                                   :active="$order === 'commercial'"
                                                   :sort="$direction"
                            >
                                Commercial
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('phone')"
                                                   class="border-b-2 dark:border-dark-5 w-24 text-xs py-2"
                                                   :active="$order === 'phone'"
                                                   :sort="$direction"
                            >
                                Téléphone
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('date_reception')"
                                                   class="border-b-2 dark:border-dark-5 w-24 text-xs py-2"
                                                   :active="$order === 'date_reception'"
                                                   :sort="$direction"
                            >
                                Date de réception
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('date_depart')"
                                                   class="border-b-2 dark:border-dark-5 w-24 text-xs py-2"
                                                   :active="$order === 'date_depart'"
                                                   :sort="$direction"
                            >
                                Date de départ
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('lieu_depart')"
                                                   class="border-b-2 dark:border-dark-5 w-24 text-xs py-2"
                                                   :active="$order === 'lieu_depart'"
                                                   :sort="$direction"
                            >
                                Lieu de départ
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('date_arrivee')"
                                                   class="border-b-2 dark:border-dark-5 w-24 text-xs py-2"
                                                   :active="$order === 'date_arrivee'"
                                                   :sort="$direction"
                            >
                                Date d'arrivée
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('lieu_arrivee')"
                                                   class="border-b-2 dark:border-dark-5 w-24 text-xs py-2"
                                                   :active="$order === 'lieu_arrivee'"
                                                   :sort="$direction"
                            >
                                Lieu d'arrivée
                            </x-crmautocar::colsort>
                            <th>
                                <div class="border-b-2 dark:border-dark-5 whitespace-nowrap text-xs py-2">
                                    Action
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($dossiers as $dossier)
                            <livewire:crmautocar::element-list-cuve :dossier="$dossier" :key="$dossier->id.'_'.$filtre"
                                                                    :filtre="$filtre"/>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <button type="button"
                            class="relative block w-full  p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path>
                        </svg>
                        <span class="mt-2 block text-sm font-medium text-gray-900">
                                Aucun dossier
                                @switch($filtre)
                                @case("attente")
                                en attente
                                @break
                                @case("distribuer")
                                de distribué
                                @break
                                @case("corbeille")
                                dans la corbeille
                                @break
                            @endswitch
                            </span>
                    </button>
                @endif
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
