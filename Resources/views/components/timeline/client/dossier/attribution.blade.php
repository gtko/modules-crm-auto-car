<x-corecrm::timeline-item>
    <x-slot name="image">
        @icon('email', 20)
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
             Dossier attribué à
            <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getCommercial())">
                {{$flow->datas->getCommercial()->format_name}}
            </x-corecrm::timeline.timeline-item-link>
            par
            <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getAttributeur())">
                {{$flow->datas->getAttributeur()->format_name}}
            </x-corecrm::timeline.timeline-item-link>
        </div>

        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
