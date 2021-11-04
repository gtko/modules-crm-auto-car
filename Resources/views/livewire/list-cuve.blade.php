<div class="grid grid-cols-12 gap-6 mt-8">

    <div class="col-span-12 lg:col-span-3 xxl:col-span-2">




        <!-- BEGIN: Inbox Menu -->
        <div class="intro-y box bg-theme-1 p-5 mt-6">
            <div class="pt-3 text-white">
                <a href="" class="flex items-center px-3 py-2 rounded-md bg-theme-25 dark:bg-dark-1 font-medium">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-mail w-4 h-4 mr-2">
                        <path
                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    En attente
                </a>
                <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-send w-4 h-4 mr-2">
                        <line x1="22" y1="2" x2="11" y2="13"></line>
                        <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                    </svg>
                    Distribué
                </a>
                <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                         class="feather feather-trash w-4 h-4 mr-2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path
                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                    </svg>
                    Corbeille
                </a>
            </div>


            <div class="border-t border-theme-3 dark:border-dark-5 mt-4 pt-4 text-white">
                @foreach($sources as $source)
                    <a href="" class="flex items-center px-3 py-2 truncate">
                        <div class="w-2 h-2 bg-theme-29 rounded-full mr-3"></div> {{$source->label}}
                    </a>
                @endforeach
            </div>
        </div>
        <!-- END: Inbox Menu -->
    </div>


    <div class="col-span-12 lg:col-span-9 xxl:col-span-10">

        <!-- BEGIN: Inbox Content -->
        <div class="intro-y inbox box mt-5">
            <div
                class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                <div
                    class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-gray-200 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                    <input class="form-check-input" type="checkbox">

                    <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                             stroke-linejoin="round" class="feather feather-refresh-cw w-4 h-4">
                            <polyline points="23 4 23 10 17 10"></polyline>
                            <polyline points="1 20 1 14 7 14"></polyline>
                            <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
                        </svg>
                    </a>
                </div>

                <div>
                    <select>
                        <option>Commercial</option>
                    </select>
                    <button wire:click="attribuer">
                        Attribuer test
                    </button>
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
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Nom</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Source</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Email</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Téléphone</th>
                        <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Date de réception</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse($dossiers as $dossier)
                        <livewire:crmautocar::element-list-cuve :dossier="$dossier" :key="$dossier->id"/>
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
