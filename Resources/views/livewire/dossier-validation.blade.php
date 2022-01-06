<div>
    @push('modals')
        <livewire:basecore::modal
            name="popup-validation-devis"
            :type="Modules\BaseCore\Entities\TypeView::TYPE_LIVEWIRE"
            path='crmautocar::form-validation-devis'
        />

    @endpush
    <div>
        <div class="overflow-x-auto">
            <table class="table mt-5">
                <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">validé</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($devis as $devi)
                    <tr>
                        <td class="border-b dark:border-dark-5">
                            {{$devi->ref}}
                        </td>
                        <td class="border-b dark:border-dark-5 text-center">
                            @if(($devi->data['validated'] ?? false))
                                @icon('checkCircle', null, 'mr-2 text-green-600')
                            @else
                                @icon('close', null, 'mr-2 text-red-600')
                            @endif

                        </td>
                        <td class="border-b dark:border-dark-5">
                            <div class="cursor-pointer" wire:click="openPopup({{$devi->id}})">
                                @icon('show', null, 'mr-2')
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
