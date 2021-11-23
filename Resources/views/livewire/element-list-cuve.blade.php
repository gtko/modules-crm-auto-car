<tr>
    <td class="border-b dark:border-dark-5">

        <input class="form-check-input flex-none" type="checkbox" wire:model="selection" value="{{$dossier->id}}">

        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}"
           class="w-6 h-6 flex-none image-fit relative ml-5">
            <img alt="" class="rounded-full" src="{{$dossier->client->avatar_url}}">
        </a>
        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}"
           class="inbox__item--sender truncate ml-3">{{$dossier->client->format_name}}</a>
    </td>
    <td class="border-b dark:border-dark-5">
        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}">
            {{$dossier->source->label}}
        </a>
    </td>
    <td class="border-b dark:border-dark-5">
        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}">
            {{$dossier->client->email}}
        </a>
    </td>
    <td class="border-b dark:border-dark-5">
        @if($dossier->commercial->id != 1)
            {{$dossier->commercial->format_name}}
        @else
            Pas attribué
        @endif

    </td>
    <td class="border-b dark:border-dark-5">
        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}">
            {{$dossier->client->phone}}
        </a>
    </td>
    <td class="border-b dark:border-dark-5">
        {{$dossier->created_at->diffForHumans()}}
    </td>
    <td>
        @if ($filtre == 'corbeille')
            <span class="cursor-pointer" title="Restaurer" wire:click="restore({{$dossier->id}})">
                @icon('save', null, 'mr-2')
            </span>
        @else
            <span class="cursor-pointer" title="Archiver" wire:click="delete({{$dossier->id}})">
                  @icon('delete', null, 'mr-2')
            </span>
        @endif
    </td>
</tr>
