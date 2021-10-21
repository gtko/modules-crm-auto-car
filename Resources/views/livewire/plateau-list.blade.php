<div class="flex justify-start flex-row flex-wrap items-start my-8">

    @foreach ($commercials as $commercial)
        <div class="box mb-3 flex items-center zoom-in w-72 mx-2 shadow-md flex-grow">
            <div class="mr-auto w-full p-2">
                <div class="font-medium text-xl py-4">{{ $commercial->formatName }}</div>

                @foreach($commercial->dossiers as $dossier)
                    <div class="text-gray-600 text-xs flex flex-row justify-between items-center py-4">
                        @dd($dossier->status->groupBy('label'))
                        @php

                        $count = $dossier->status->groupBy('label')->count()
                        @endphp
                        <div>{{ $dossier->status->groupBy('label')  }}</div>
                        <div class="bg-red-600 text-white p-1 mr-4"> $count</div>
                    </div>
                    <hr class="mx-2">
                @endforeach
            </div>
        </div>

    @endforeach
</div>
