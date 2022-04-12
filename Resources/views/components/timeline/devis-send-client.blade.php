<x-corecrm::timeline-item>
    <x-slot name="image">
        @icon('email', 20)
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            @if($flow->datas->getDevis())
            Envoie du devis
            <x-corecrm::timeline.timeline-item-link :url="route('devis.edit', [$flow->datas->getDevis()->dossier->client, $flow->datas->getDevis()->dossier, $flow->datas->getDevis()])">
                #{{$flow->datas->getDevis()->ref}}
            </x-corecrm::timeline.timeline-item-link>
            au client "{{$flow->datas->getDevis()->dossier->client->email}}"
            @else
                <span class="text-red-500">Devis supprimé</span>
            @endif
        </div>

        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
