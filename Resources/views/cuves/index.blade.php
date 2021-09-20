<x-basecore::app-layout>
    <x-slot name="breadcrumb">
        <x-basecore::breadcrumb-item>Cuves</x-basecore::breadcrumb-item>
    </x-slot>

    <div class="grid grid-cols-12 gap-6 mt-8">

        <div class="col-span-12 lg:col-span-3 xxl:col-span-2">
            <!-- BEGIN: Inbox Menu -->
            <div class="intro-y box bg-theme-1 p-5 mt-6">
                <div class="pt-3 text-white">
                    <a href="" class="flex items-center px-3 py-2 rounded-md bg-theme-25 dark:bg-dark-1 font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail w-4 h-4 mr-2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                        En attente
                    </a>
                    <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send w-4 h-4 mr-2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        Distribué
                    </a>
                    <a href="" class="flex items-center px-3 py-2 mt-2 rounded-md">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash w-4 h-4 mr-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
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

            <!-- This example requires Tailwind CSS v2.0+ -->
            <div>
                <dl class="mt-5 grid grid-cols-1 rounded-lg bg-white overflow-hidden shadow divide-y divide-gray-200 md:grid-cols-3 md:divide-y-0 md:divide-x">
                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-base font-normal text-gray-900">
                            Dossier en attente
                        </dt>
                        <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                            <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                                15
                                <span class="ml-2 text-sm font-medium text-gray-500">
                                    sur 190 depuis 48h
                                </span>
                            </div>

                            <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                                <!-- Heroicon name: solid/arrow-sm-up -->
                                <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">
                                    Increased by
                                </span>
                                12%
                            </div>
                        </dd>
                    </div>

                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-base font-normal text-gray-900">
                            Délais de distribution
                        </dt>
                        <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                            <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                                5 minutes
                            </div>

                            <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 md:mt-2 lg:mt-0">
                                <!-- Heroicon name: solid/arrow-sm-up -->
                                <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">
                                    Increased by
                                </span>
                                2.02%
                            </div>
                        </dd>
                    </div>

                    <div class="px-4 py-5 sm:p-6">
                        <dt class="text-base font-normal text-gray-900">
                           Dossier reçu par jours
                        </dt>
                        <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                            <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                               18
                            </div>

                            <div class="inline-flex items-baseline px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800 md:mt-2 lg:mt-0">
                                <!-- Heroicon name: solid/arrow-sm-down -->
                                <svg class="-ml-1 mr-0.5 flex-shrink-0 self-center h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                <span class="sr-only">
                                   Decreased by
                                </span>
                                4.05%
                            </div>
                        </dd>
                    </div>
                </dl>
            </div>


            <!-- BEGIN: Inbox Content -->
            <div class="intro-y inbox box mt-5">
                <div class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">
                    <div class="flex items-center mt-3 sm:mt-0 border-t sm:border-0 border-gray-200 pt-5 sm:pt-0 mt-5 sm:mt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                        <input class="form-check-input" type="checkbox">

                        <a href="javascript:;" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw w-4 h-4"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                        </a>
                    </div>
                    <div class="flex items-center sm:ml-auto">
                        <div class="dark:text-gray-300">1 - 50 sur {{$total}}</div>
                        <a href="{{$prev}}" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left w-4 h-4"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </a>
                        <a href="{{$next}}" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right w-4 h-4"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto sm:overflow-x-visible">
                    @forelse($dossiers as $dossier)
                        <div class="intro-y">
                            {{--  class inbox__item--active --}}
                            <div class="inbox__item  inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                                <div class="flex px-5 py-3">
                                    <div class="w-64 flex-none flex items-center mr-5">

                                        <input class="form-check-input flex-none" type="checkbox">


                                        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}" class="w-6 h-6 flex-none image-fit relative ml-5">
                                            <img alt="" class="rounded-full" src="{{$dossier->client->avatar_url}}">
                                        </a>
                                        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}" class="inbox__item--sender truncate ml-3">{{$dossier->client->format_name}}</a>

                                    </div>
                                    <div class="flex-grow sm:w-auto flex items-center flex-wrap">
                                        <div class="inbox__item--sender w-2/12  truncate pr-1">{{$dossier->source->label}}</div>

                                        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}" class="w-4/12  inbox__item--sender  flex items-center truncate pl-3">
                                            <span class="mr-1">@icon('email', 16)</span> <span class="truncate">{{$dossier->client->email}}</span>
                                        </a>
                                        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}" class="w-3/12   inbox__item--sender flex items-center truncate pl-3">
                                            <span class="mr-1">@icon('phone', 16)</span> <span class="truncate">{{$dossier->client->phone}}</span>
                                        </a>
                                        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}" class="w-3/12   inbox__item--sender flex items-center  pl-3">
                                            <span class="mr-1">@icon('calendar', 16)</span> <span class="truncate">{{$dossier->date_start->format('d/m/Y')}}</span>
                                        </a>

                                    </div>
                                    <div class="inbox__item--time whitespace-nowrap ml-auto pl-10">{{$dossier->created_at->diffForHumans()}}</div>
                                </div>
                            </div>
                        </div>
                    @empty
                    <!-- This example requires Tailwind CSS v2.0+ -->
                        <button type="button" class="relative block w-full  p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1M4 7l2-1M4 7l2 1M4 7v2.5M12 21l-2-1m2 1l2-1m-2 1v-2.5M6 18l-2-1v-2.5M18 18l2-1v-2.5"></path></svg>
                            <span class="mt-2 block text-sm font-medium text-gray-900">
                                Aucun dossier en attente
                            </span>
                        </button>
                    @endforelse
                </div>
                <div class="p-5 flex flex-col sm:flex-row items-center text-center sm:text-left text-gray-600">
                    @if($dossiers->first())
                        <div class="sm:ml-auto mt-2 sm:mt-0 dark:text-gray-300">Derniers dossier {{$dossiers->first()?->created_at->diffForHumans()}}</div>
                    @endif
                </div>
            </div>
            <!-- END: Inbox Content -->
        </div>
    </div>

</x-basecore::app-layout>
