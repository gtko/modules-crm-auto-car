<x-corecrm::timeline-item>
    <x-slot name="image">
        @icon('mail', 20)
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            Informations voyage envoyées pour le
            <x-corecrm::timeline.timeline-item-link :url="route('devis.edit', [$flow->datas->getDevis()->dossier->client, $flow->datas->getDevis()->dossier, $flow->datas->getDevis()])">
              devis #{{$flow->datas->getDevis()->ref}}
            </x-corecrm::timeline.timeline-item-link>
             par
            <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getUser())">
                {{$flow->datas->getUser()->format_name}}
            </x-corecrm::timeline.timeline-item-link>
            au fournisseur {{$flow->datas->getDatas()['fournisseur_name'] ?? 'N/A'}}
            sur l'email {{$flow->datas->getDatas()['fournisseur_email'] ?? 'N/A'}}

        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
