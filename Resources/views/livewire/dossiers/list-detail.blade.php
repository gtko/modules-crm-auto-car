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
        <div style="background-color:{{$dossier->status_color}}"
             class="py-1 px-2 rounded text-xs text-white cursor-pointer font-medium">
            {{$dossier->status_label}}
        </div>
    </td>

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
