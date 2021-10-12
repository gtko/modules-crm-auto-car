<div class="intro-y mt-5">
    @if($this->dossiers)
        <div class="p-5 flex flex-col-reverse sm:flex-row text-gray-600 border-b border-gray-200 dark:border-dark-1">

            {{--            <div class="flex items-center sm:ml-auto">--}}
            {{--                            <div class="dark:text-gray-300">1 - 50 sur {{$clients->count()}}</div>--}}
            {{--                <a href="{{$prev}}" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">--}}
            {{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"--}}
            {{--                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"--}}
            {{--                         stroke-linejoin="round" class="feather feather-chevron-left w-4 h-4">--}}
            {{--                        <polyline points="15 18 9 12 15 6"></polyline>--}}
            {{--                    </svg>--}}
            {{--                </a>--}}
            {{--                <a href="{{$next}}" class="w-5 h-5 ml-5 flex items-center justify-center dark:text-gray-300">--}}
            {{--                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"--}}
            {{--                         fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"--}}
            {{--                         stroke-linejoin="round" class="feather feather-chevron-right w-4 h-4">--}}
            {{--                        <polyline points="9 18 15 12 9 6"></polyline>--}}
            {{--                    </svg>--}}
            {{--                </a>--}}
            {{--            </div>--}}
        </div>



        <div class="overflow-x-auto sm:overflow-x-visible">
            @foreach($this->dossiers as $dossier)
                <div class="intro-y">
                    <div
                        class="inbox__item  inline-block sm:block text-gray-700 dark:text-gray-500 bg-gray-100 dark:bg-dark-1 border-b border-gray-200 dark:border-dark-1">
                        <div class="flex px-5 py-3">
                            <div class="flex-none flex items-center mr-5 grid-cols-4">

                                <span>
                                    <a href="{{route('clients.show', [$dossier->client])}}"
                                       class="w-6 h-6 flex-none image-fit relative ml-5">
                                    <img alt="" class="rounded-full" src="{{$dossier->client->avatar_url}}">
                                </a>
                                <a href="{{route('clients.show', [$dossier->client])}}"
                                   class="inbox__item--sender truncate ml-3">{{$dossier->client->format_name}}</a>
                                </span>

                                <span>
                                    <a href="{{route('clients.show', [$dossier->client])}}"
                                       class="w-4/12  inbox__item--sender  flex items-center truncate pl-3">
                                    <span class="mr-1">@icon('email', 16)</span> <span
                                            class="truncate">{{$dossier->client->email}}</span>
                                </a>
                                </span>

                                <span>
                                      <a href="{{route('clients.show', [$dossier->client])}}"
                                         class="w-3/12   inbox__item--sender flex items-center truncate pl-3">
                                    <span class="mr-1">@icon('phone', 16)</span> <span
                                              class="truncate">{{$dossier->client->phone}}</span>
                                </a>
                                </span>

                                <span class="inbox__item--time whitespace-nowrap ml-auto pl-10">
                                {{$dossier->client->created_at->diffForHumans()}}
                            </span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                @endif
        </div>
</div>
