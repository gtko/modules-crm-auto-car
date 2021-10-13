<div class="intro-y mt-5">
    @if($this->dossiers)
        <table class="table bg-white">
            <thead>
            <tr>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Nom</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Email</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Créé le</th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->dossiers as $dossier)
                <tr>
                    <td class="border-b dark:border-dark-5">
                        <a href="{{route('clients.show', [$dossier->client])}}"
                           class="inbox__item--sender truncate ml-3">{{$dossier->client->format_name}}</a>
                    </td>
                    <td class="border-b dark:border-dark-5">

                        <a href="{{route('clients.show', [$dossier->client])}}">
                            {{$dossier->client->email}}
                        </a>

                    </td>
                    <td class="border-b dark:border-dark-5">
                         <span class="inbox__item--time whitespace-nowrap ml-auto pl-10">
                                {{$dossier->client->created_at->diffForHumans()}}
                            </span>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

</div>
