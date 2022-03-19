<x-corecrm::timeline-item>
    <x-slot name="image">
        @icon('pdf', 20)
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            Création de la facture proforma
            @if($flow->datas->getProformat())
            {{$flow->datas->getProformat()->id ?? '-'}}
            @else
             <span class="text-red-600">Supprimé</span>
            @endif
        </div>

        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
