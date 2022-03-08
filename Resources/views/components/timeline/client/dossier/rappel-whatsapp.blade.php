<x-corecrm::timeline-item>
    <x-slot name="image">
        <img alt="" src="{{$flow->datas->getCommercial()->avatar_url}}"/>
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            Demande de rappel envoyé via WhatsApp par
            <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getCommercial())">
                {{$flow->datas->getCommercial()->format_name}}
            </x-corecrm::timeline.timeline-item-link>
        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
