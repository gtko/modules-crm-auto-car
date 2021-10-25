<div class="flex justify-start flex-row flex-wrap items-start my-8 grid sm:grid-cols-1  sm:grid-cols-2 md:grid-cols-3 gap-4">

    @foreach ($commercials as $commercial)
        <div class="box mb-3 flex items-center zoom-in mx-2 shadow-md flex-grow">
            <div class="mr-auto w-full p-2">
                <div class="flex flex-row justify-between items-center">
                    <div class="font-medium text-xl py-4">{{ $commercial->formatName }}</div>
                    <div>
                        <a href="/users/{{$commercial->id}}/edit">@icon('edit', null, 'mr-2')</a></div>
                </div>
                <livewire:crmautocar::plateau-list-detail :commercialId="$commercial->id" wire:key="$commercial->id"/>
            </div>
        </div>

    @endforeach
</div>

