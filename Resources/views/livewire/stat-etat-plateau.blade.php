<div>


    <div class="grid grid-cols-4 gap-4">
        @foreach($commercials as $commercial)
            <x-basecore::partials.card>
                <h3 class="text-lg mb-3">{{$commercial->format_name}}</h3>

                <ul>
                @foreach($status as $statu)
                    <li class="mb-1 text-white rounded p-2 flex items-center justify-between" style="background:{{$statu->color}}">
                        <span>{{$statu->label}}</span>
                        <span>{{ $commercial->{"count_" . $statu->id} }}</span>
                    </li>
                @endforeach
                </ul>
            </x-basecore::partials.card>
        @endforeach
    </div>

</div>
