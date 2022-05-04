<tr @if($validate ?? false) class="bg-green-400" @endif>
    <td class="border-b dark:border-dark-5">
        <div class="flex flex-col">
            <a href="{{route('devis.edit', [$client, $dossier, $proformat->devis])}}">#{{$proformat->devis->ref}}</a>
            <small class="text-xs whitespace-nowrap">{{$proformat->number ?? ''}}</small>
        </div>
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
        <div class="flex justify-center items-center space-x-2">
        @if($editDate ?? false)
            <div class="flex flex-col">
                <x-basecore::inputs.datetime label="" name="acceptation_date"
                     wire:model="acceptation_date"
                     placeholder="Accepté le"
                     required
                />
            </div>
            <span wire:click="saveAcception()" class="cursor-pointer">@icon('checkCircle', null, 'mr-2')</span>
        @else
            @if($proformat->acceptation_date)
                {{$proformat->acceptation_date->format('d/m/Y H:i')}}
            @else
                <span class="text-red-500 whitespace-nowrap">Non accepté</span>
            @endif
            @if(\Illuminate\Support\Facades\Auth::user()->isSuperAdmin())
                <span wire:click="editDate()" class="cursor-pointer">@icon('edit', null, 'mr-2')</span>
            @endif
        @endif
        </div>
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
                <a class="flex items-center cursor-pointer" target="_blank"
                   href="{{route('proformats.show', $proformat->id)}}">
                    @icon('show', null, 'mr-2')
                </a>
            </div>

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

                <a class="flex items-center cursor-pointer" target="_blank"
                   href="{{route('proformats.pdf', $proformat->id)}}">
                    @icon('pdf', null, 'mr-2')
                </a>

                @can('delete', $proformat)
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
