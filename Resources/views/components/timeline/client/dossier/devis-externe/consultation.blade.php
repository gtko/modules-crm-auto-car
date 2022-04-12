<x-corecrm::timeline-item>
    <div class="flex items-center">
        <x-slot name="image">
            @icon('show', 20)
        </x-slot>
        <div class="font-medium">
            Devis
            @if($flow->datas->getDevis()->dossier->client ?? false)
                <x-corecrm::timeline.timeline-item-link
                    :url="route('devis.edit', [$flow->datas->getDevis()->dossier->client ?? null, $flow->datas->getDevis()->dossier ?? null, $flow->datas->getDevis() ?? null])">
                    devis #{{$flow->datas->getDevis()->ref}}
                </x-corecrm::timeline.timeline-item-link>
            @endif
            consulté depuis l'IP
            <span class="text-yellow-600">
            {{ $flow->datas->getIp() }}
            </span>


        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
