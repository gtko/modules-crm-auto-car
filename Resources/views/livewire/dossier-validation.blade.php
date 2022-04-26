<div>
    @push('modals')
        <livewire:basecore::modal
            name="popup-validation-devis"
            :type="Modules\BaseCore\Entities\TypeView::TYPE_LIVEWIRE"
            path='crmautocar::form-validation-devis'
            size="2xl"
        />
    @endpush
    <div>
        <div class="overflow-x-auto">
            <table class="table mt-5">
                <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">validé</th>
                    <th class="whitespace-nowrap">envoyé</th>
                    <th class="whitespace-nowrap">Actions</th>
                    <i class="bi bi-zoom-out"></i>
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
                        <td class="border-b dark:border-dark-5 text-center">
                            @if(($devi->data['sended'] ?? false))
                                @icon('checkCircle', null, 'mr-2 text-green-600')
                            @else
                                @icon('close', null, 'mr-2 text-red-600')
                            @endif
                        </td>
                        <td class="border-b dark:border-dark-5 flex flex-row">
                            <div class="cursor-pointer mr-4" title="voir" wire:click="openPopup({{$devi->id}})">
                                @icon('checkCircle', null, 'mr-2')
                            </div>
                            <a class="cursor-pointer" target="_blank" title="voir la feuille de route" href="{{(new \Modules\BaseCore\Actions\Url\SigneRoute)->signer('info-voyage.show',[$devi])}}">
                                @icon('show', null, 'mr-2')
                            </a>
                            <a class="cursor-pointer" title="feuille de route" href="{{(new \Modules\BaseCore\Actions\Url\SigneRoute)->signer('info-voyage.pdf',[$devi])}}">
                                @icon('pdf', null, 'mr-2')
                            </a>
                            <x-basecore::loading-replace wire:target="envoyer({{$devi->id}})">
                                <div class="cursor-pointer" title="send" wire:click="envoyer({{$devi->id}})">
                                    @icon('email', null, 'mr-2')
                                </div>
                            </x-basecore::loading-replace>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
