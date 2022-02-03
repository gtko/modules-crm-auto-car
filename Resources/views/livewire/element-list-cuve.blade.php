<tr>
    <td class="border-b dark:border-dark-5 text-xs">
        <div class="flex items-center w-24">
            <input class="form-check-input flex-none" type="checkbox" wire:model="selection" value="{{$dossier->id}}">

            <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}"
               class="inbox__item--sender ml-3">{{$dossier->client->format_name}}</a>
        </div>
    </td>
    <td class="border-b dark:border-dark-5 text-xs">
        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}">
            {{$dossier->source->label}}
        </a>
    </td>
    <td class="border-b dark:border-dark-5 text-xs">
        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}">
            {{$dossier->client->email}}
        </a>
    </td>
    <td class="border-b dark:border-dark-5 text-xs">
        @if($dossier->commercial->id != 1)
            {{$dossier->commercial->format_name}}
        @else
            Pas attribué
        @endif

    </td>
    <td class="border-b dark:border-dark-5 text-xs">
        <a href="{{route('dossiers.show', [$dossier->client, $dossier])}}">
            {{$dossier->client->phone}}
        </a>
    </td>
    <td class="border-b dark:border-dark-5 text-xs">
        {{$dossier->created_at->diffForHumans()}}
    </td>
    <td class="border-b dark:border-dark-5 text-xs">
        {{ $dossier->data['date_depart'] ?? 'N/A'}}
    </td>
    <td class="border-b dark:border-dark-5 text-xs">
        {{ $dossier->data['lieu_depart'] ?? 'N/A'}}
    </td>
    <td class="border-b dark:border-dark-5 text-xs">
        {{ $dossier->data['date_arrivee'] ?? 'N/A'}}
    </td>
    <td class="border-b dark:border-dark-5 text-xs">
        {{ $dossier->data['lieu_arrivee'] ?? 'N/A'}}
    </td>
    <td class="border-b dark:border-dark-5 text-xs">
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
