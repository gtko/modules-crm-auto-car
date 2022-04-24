<tr @if($validate ?? false) class="bg-green-400" @endif>
    <td class="border-b dark:border-dark-5 w-48">
        {{$proformat->number ?? ''}}
    </td>

    <td class="border-b dark:border-dark-5 whitespace-nowrap">
        {{$proformat->devis->title ?? ''}}
    </td>
    <td class="border-b dark:border-dark-5">
        @can('changeCommercial', Modules\CrmAutoCar\Models\Proformat::class)
            <div class="flex flex-row w-48">
                <x-basecore::inputs.select wire:model="commercial" name="commercial"
                                           class="form-control-sm @if($validate ?? false) bg-green-300 @endif">
                    <option value="">Commercial</option>
                    @foreach($commercials as $commer)
                        <option value="{{$commer->id}}">{{$commer->format_name}}</option>
                    @endforeach
                </x-basecore::inputs.select>
                <x-basecore::loading-replace wire:target="save()">
                    <span wire:click="save()" class="cursor-pointer">
                        @icon('check', null, 'mr-2 ml-1')
                    </span>
                </x-basecore::loading-replace>
            </div>
        @else
            {{$proformat->devis->commercial->format_name}}
        @endcan
    </td>
    <td class="border-b dark:border-dark-5">
        {{$proformat->created_at->format('d/m/Y H:i')}}
    </td>
    <td class="border-b dark:border-dark-5">
        <a href="{{route('devis.edit', [$client, $dossier, $proformat->devis])}}">#{{$proformat->devis->ref}}</a>
    </td>
    <td class="border-b dark:border-dark-5">
        {{ $proformat->devis->getTotal()}}€
    </td>
    <td class="border-b dark:border-dark-5">
        @marge($proformat->price->getMargeHT())€
    </td>
    <td class="border-b dark:border-dark-5">
        {{ $proformat->price->paid()}}€
    </td>
    <td class="border-b dark:border-dark-5">
        {{ $proformat->price->remains()}}€
    </td>
    <td class="border-b dark:border-dark-5">
        <div class="flex justify-between items-center">
            <div class="flex justify-center items-center mr-2">
                <x-basecore::loading-replace wire:target="sendProformat">
                <span class="flex items-center cursor-pointer" wire:click="sendProformat">
                    @icon('mail', null, 'mr-2')
                </span>
                </x-basecore::loading-replace>

                <x-basecore::loading-replace wire:target="sendInformationVoyage">
                <span class="flex items-center cursor-pointer" wire:click="sendInformationVoyage">
                   @icon('badgeCheck', null, 'mr-2')
                </span>
                </x-basecore::loading-replace>


            </div>
            <div class="flex justify-center items-center">
                <a class="flex items-center mr-3 cursor-pointer" target="_blank"
                   href="{{route('proformats.show', $proformat->id)}}">
                    @icon('show', null, 'mr-2')
                </a>
                <a class="flex items-center cursor-pointer" target="_blank"
                   href="{{route('proformats.pdf', $proformat->id)}}">
                    @icon('pdf', null, 'mr-2')
                </a>

                @can('delete', Modules\CrmAutoCar\Models\Proformat::class)
                    <x-basecore::loading-replace wire:target="delete">
                    <span class="flex items-center cursor-pointer" wire:click="delete">
                     @icon('delete', null, 'mr-2')
                    </span>
                    </x-basecore::loading-replace>
                @endcan
            </div>
        </div>
    </td>
</tr>
