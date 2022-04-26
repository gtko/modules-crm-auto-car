<tr>
    <td class="border-b dark:border-dark-5">
        {{$devis->ref}}
    </td>
    <td class="border-b dark:border-dark-5 text-center">
        @if(($devis->data['validated'] ?? false))
            @icon('checkCircle', null, 'mr-2 text-green-600')
        @else
            @icon('close', null, 'mr-2 text-red-600')
        @endif

    </td>
    <td class="border-b dark:border-dark-5 text-center">
        @if(($devis->data['sended'] ?? false))
            @icon('checkCircle', null, 'mr-2 text-green-600')
        @else
            @icon('close', null, 'mr-2 text-red-600')
        @endif
    </td>
    <td class="border-b dark:border-dark-5 flex flex-row">
        <div class="cursor-pointer mr-4" title="voir" wire:click="openPopup()">
            @icon('checkCircle', null, 'mr-2')
        </div>
        <a class="cursor-pointer" target="_blank" title="voir la feuille de route" href="{{(new \Modules\BaseCore\Actions\Url\SigneRoute)->signer('info-voyage.show',[$devis])}}">
            @icon('show', null, 'mr-2')
        </a>
        <a class="cursor-pointer" title="feuille de route" href="{{(new \Modules\BaseCore\Actions\Url\SigneRoute)->signer('info-voyage.pdf',[$devis])}}">
            @icon('pdf', null, 'mr-2')
        </a>
        <x-basecore::loading-replace wire:target="envoyer()">
            <div class="cursor-pointer" title="send" wire:click="envoyer()">
                @icon('email', null, 'mr-2')
            </div>
        </x-basecore::loading-replace>
    </td>
</tr>
