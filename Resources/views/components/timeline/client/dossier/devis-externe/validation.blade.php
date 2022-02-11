<x-corecrm::timeline-item>
    <div class="flex items-center">
        <x-slot name="image">
            @icon('checkCircle', 30, 'text-green-600')
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
            <div>
                Avec les infos suivante :
               <ul>
                   <li>Nom : <span class="text-yellow-600">{{ ($flow->datas->getData()['nom_validation'] ?? '') . ' ' .  ($flow->datas->getData()['nom_validation'] ?? '')}}</span></li>
                   <li>Société : <span class="text-yellow-600">{{ $flow->datas->getData()['societe_validation'] ?? '' }}</span></li>
                   <li>Adresse : <span class="text-yellow-600">{{ $flow->datas->getData()['address_validation'] ?? ''}}</span></li>
                   <li>Type de paiment : <span class="text-yellow-600">{{ $flow->datas->getData()['paiement_type_validation'] ?? '' }}</span></li>
               </ul>
            </div>
        </div>
        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
