<x-corecrm::timeline-item>
    <div class="flex items-center">
        <x-slot name="image">
        </x-slot>
        <div class="font-medium">
            Devis
            <x-corecrm::timeline.timeline-item-link
                :url="route('devis.edit', [$flow->datas->getDevis()->dossier->client, $flow->datas->getDevis()->dossier, $flow->datas->getDevis()])">
                devis #{{$flow->datas->getDevis()->ref}}
            </x-corecrm::timeline.timeline-item-link>
            <span class="text-green-400">
            Validé
            </span>
            depuis l'IP
            <span class="text-yellow-600">
            {{ $flow->datas->getIp() }}
            </span>


        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
