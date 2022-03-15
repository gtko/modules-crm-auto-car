<tr>
    <td>
        <div class="w-10 h-10 image-fit zoom-in">
            <img alt="" class="tooltip rounded-full" src="{{$dossier->client->avatar_url}}">
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
                    <span @click="open = true" x-show="!open">Voir {{$dossier->tags->count() - 2}} de plus ...</span>
                </div>
            @elseif($index == $dossier->tags->count() - 1 )
                <div class="flex justify-center text-xs text-white rounded bg-green-400">
                    <span @click="open = false" x-show="open">Voir moins ...</span>
                </div>
            @endif

        @endforeach
    </td>
    <td class="text-center">
        @foreach($dossier->devis as $devi)
            @if ($devi->date_depart != '' && $devi->date_retour != '')
                <div class="flex flex-row text-xs whitespace-nowrap">
                    du {{$devi->date_depart->format('d/m/Y')}}
                    au {{$devi->date_retour->format('d/m/Y')}}
                </div>
            @endif

        @endforeach
    </td>

    <td>
        @if($resa)

            <livewire:corecrm::follower-dossier :tomselect="false" :label="false" :roles="[7]" :client="$dossier->client" :dossier="$dossier"/>

        @else
            <div class="flex flex-row justify-start items-center whitespace-nowrap">
                <div class="w-10 h-10 image-fit zoom-in">
                    <img alt="" class="tooltip rounded-full" src="{{$dossier->commercial->avatar_url}}">
                </div>
                <div class="ml-2">
                    {{$dossier->commercial->format_name}}
                </div>
            </div>
        @endif
    </td>
    <td>
        {{ $dossier->created_at->format('d-m-Y h:i') }}
    </td>
    <td class="table-report__action">
        <div class="flex justify-center items-center">
            <a class="flex items-center mr-3" href="/clients/{{$dossier->client->id}}/dossiers/{{$dossier->id}}">
                @icon('show', null, 'mr-2') Voir
            </a>
        </div>
    </td>
</tr>
