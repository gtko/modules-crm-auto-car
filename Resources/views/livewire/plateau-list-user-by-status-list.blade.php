<div class="col-span-12 mt-6">
    <div class="intro-y block sm:flex items-center h-10">
        <h2 class="text-lg font-medium truncate mr-5">Réservations</h2>
    </div>
    <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
        <table class="table table-report sm:mt-2">
            <thead>
            <tr>
                <th class="whitespace-nowrap">ID</th>
                <th class="whitespace-nowrap">Nom</th>
                <th class="whitespace-nowrap">Téléphone</th>
                <th class="whitespace-nowrap">Date de réception</th>
                <th class="whitespace-nowrap">Date de départ</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dossiers as $dossier)
                <tr>
                    <td class="w-40">
                        <a href="/clients/{{ $dossier->client->id }}/dossiers/{{ $dossier->id }}">{{ $dossier->ref }}</a>
                    </td>
                    <td>
                        <a href="/clients/{{ $dossier->client->id }}/dossiers/{{ $dossier->id }}">{{ $dossier->client->format_name }}</a>
                    </td>

                    <td class="text-center">
                        {{ $dossier->client->phone }}
                    </td>

                    <td class="text-center">
                        {{ $dossier->created_at }}
                    </td>

                    <td class="text-center">
                        {{ $dossier->date_start }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    {{$proformats->links()}}--}}

</div>

