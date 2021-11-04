<x-corecrm::timeline-item>
    <x-slot name="image">
        @icon('pdf', 20)
    </x-slot>
    <div class="flex items-center">
        <div class="font-medium">
            Création de la facture proformat
        </div>

        <div class="text-xs text-gray-500 ml-auto">{{$flow->created_at->format('H:i')}}</div>
    </div>
</x-corecrm::timeline-item>
