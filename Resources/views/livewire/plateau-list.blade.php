<div class="flex justify-start flex-row flex-wrap items-start my-8">

    @foreach ($commercials as $commercial)
        <div class="box mb-3 flex items-center zoom-in w-72 mx-2 shadow-md flex-grow">
            <div class="mr-auto w-full p-2">
                <div class="font-medium text-xl py-4">{{ $commercial->formatName }}</div>
                <livewire:crmautocar::plateau-list-detail :commercialId="$commercial->id"/>
            </div>
        </div>

    @endforeach
</div>
