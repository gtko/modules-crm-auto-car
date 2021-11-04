<x-corecrm::timeline-item>
    <x-slot name="image">
        @icon('delete', 20)
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            Demande fournisseur {{$flow->datas->getFournisseur()->formatName}} ({{$flow->datas->getFournisseur()->email}}) pour le
            <x-corecrm::timeline.timeline-item-link :url="route('devis.edit', [$flow->datas->getDevis()->dossier->client, $flow->datas->getDevis()->dossier, $flow->datas->getDevis()])">
              devis #{{$flow->datas->getDevis()->ref}}
            </x-corecrm::timeline.timeline-item-link>
            au prix de
            {{$flow->datas->getPrix()}}€
            est <span class="text-red-600">supprimée</span>
            par
            <x-corecrm::timeline.timeline-item-link :url="route('users.show', $flow->datas->getUser())">
                {{$flow->datas->getUser()->format_name}}
            </x-corecrm::timeline.timeline-item-link>

        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
