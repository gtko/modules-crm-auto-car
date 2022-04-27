<tr link="{{route('dossiers.show', [$dossier->client,$dossier])}}">
    <td>
        <div class="w-10 h-10 image-fit zoom-in">
            <img alt="" class="tooltip rounded-full" src="{{$dossier->client->avatar_url}}">
        </div>

    </td>
    <td class="w-12">
        <div class="grid grid-cols-2 gap-1">
            @foreach($dossier->commercial->roles()->whereIn('id', config('crmautocar.bureaux_ids'))->get() as $bureau)
                <span class="text-xs text-center py-1 px-1 bg-gray-200 whitespace-nowrap overflow-ellipsis rounded">
                    {{trim(str_replace('Bureau', '',$bureau->name))}}
                </span>
            @endforeach
        </div>
    </td>
    <td>
        <div class="">
            <a href="/clients/{{$dossier->client->id}}/dossiers/{{$dossier->id}}">#{{$dossier->ref}}</a>
        </div>
    </td>
    <td class="text-center">
        {{$dossier->client->format_name}}
    </td>
    <td class="text-center">
        {{$dossier->client->company ?? 'N/A'}}
    </td>
    <td class="text-center">
        <div style="background-color:{{$dossier->status_color}}"
             class="py-1 px-2 rounded text-xs text-white font-medium ">
            {{$dossier->status_label}}
        </div>
    </td>
    <td class="text-center space-y-1" x-data="{open: false}">
        @foreach($dossier->tags as $index => $tag)
            @if ($index < 2)
                <div style="background-color:{{$tag->color}}"
                     class="py-1 px-2 rounded text-xs text-white font-medium whitespace-nowrap">
                    {{$tag->label}}
                </div>
            @else

                <div style="background-color:{{$tag->color}}" x-show="open"
                     class="py-1 px-2 rounded text-xs text-white font-medium whitespace-nowrap">
                    {{$tag->label}}
                </div>
            @endif

            @if($index == 2)
                <div class="flex justify-center text-xs text-white rounded bg-green-400">
                    <span @click.stop="open = true"
                          x-show="!open">Voir {{$dossier->tags->count() - 2}} de plus ...</span>
                </div>
            @elseif($index == $dossier->tags->count() - 1 )
                <div class="flex justify-center text-xs text-white rounded bg-green-400">
                    <span @click.stop="open = false" x-show="open">Voir moins ...</span>
                </div>
            @endif

        @endforeach
    </td>
    <td class="text-center">
        @foreach($dossier->devis->where('validate', true) as $devi)
            @if($devi->date_depart != '' || $devi->date_retour != '')
                <div
                    class="flex flex-col text-xs whitespace-nowrap @if($dossier->devis->where('validate', true)->count() > 1) mb-1 @endif">
                    @if($devi->date_depart != '') <span>du {{$devi->date_depart->format('d/m/Y')}}</span> @endif
                    @if($devi->date_retour != '') <span>au {{$devi->date_retour->format('d/m/Y')}}</span> @endif
                </div>
            @endif

        @endforeach
    </td>
    @if($resa)
        <td ignore-link>
            <livewire:corecrm::follower-dossier :tomselect="false" :label="false" :roles="[7]"
                                                :client="$dossier->client" :dossier="$dossier"/>
        </td>
    @endif
    <td>
        <div class="flex flex-row justify-start items-center whitespace-nowrap">
            <div class="w-10 h-10 image-fit zoom-in">
                <img alt="" class="tooltip rounded-full" src="{{$dossier->commercial->avatar_url}}">
            </div>
            <div class="ml-2">
                {{$dossier->commercial->format_name}}
            </div>
        </div>
    </td>
    <td>

        @if($dossier->signed)
            <span class="text-green-600">{{$dossier->signature_at->format('d-m-Y H:i')}}</span>
        @else
            <span class="text-gray-400">Aucune signature</span>
        @endif
    </td>
    <td class="table-report__action">
        <div class="flex justify-center items-center">
            <a class="flex items-center mr-3" href="/clients/{{$dossier->client->id}}/dossiers/{{$dossier->id}}">
                @icon('show', null, 'mr-2') Voir
            </a>
        </div>
    </td>
</tr>
