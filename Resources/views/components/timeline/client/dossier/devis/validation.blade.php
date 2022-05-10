<x-corecrm::timeline-item>
    <x-slot name="image">
        @icon('mail', 20)
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            Informations validées pour le
            @if($flow->datas->getDevis())
            <x-corecrm::timeline.timeline-item-link :url="route('devis.edit', [$flow->datas->getDevis()->dossier->client, $flow->datas->getDevis()->dossier, $flow->datas->getDevis()])">
              devis #{{$flow->datas->getDevis()->ref}}
            </x-corecrm::timeline.timeline-item-link>
            @else
                <div>aucun devis</div>
            @endif
             par
            <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getUser())">
                {{$flow->datas->getUser()->format_name}}
            </x-corecrm::timeline.timeline-item-link>

        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
