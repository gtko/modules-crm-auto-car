<x-corecrm::timeline-item>
    <x-slot name="image">
        @icon('mail', 20)
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            @if($flow->datas->getDevis()->dossier ?? false)
                <x-corecrm::timeline.timeline-item-link :url="route('devis.edit', [$flow->datas->getDevis()->dossier->client, $flow->datas->getDevis()->dossier, $flow->datas->getDevis()])">
                  Devis #{{$flow->datas->getDevis()->ref}}
                </x-corecrm::timeline.timeline-item-link>
                 Envoyer par WhatsApp par
                <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getUser())">
                    {{$flow->datas->getUser()->format_name}}
                </x-corecrm::timeline.timeline-item-link>
            @else
                Le devis n'existe plus
            @endif
        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
