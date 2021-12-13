<div>


    <div>
        <div class="overflow-x-auto">
            <table class="table mt-5">
                <thead>
                <tr class="text-gray-700">
                    <th class="whitespace-nowrap" colspan="6">
                        {{$proformats->count()}} proformats
                    </th>
                </tr>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Commercial</th>
                    <th class="whitespace-nowrap">Date</th>
                    <th class="whitespace-nowrap">devis</th>
                    <th class="whitespace-nowrap">total</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($proformats as $proformat)
                    <tr>
                        <td class="border-b dark:border-dark-5">
                           {{$proformat->number}}
                        </td>
                        <td class="border-b dark:border-dark-5">
                            {{$proformat->devis->commercial->format_name}}
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
                            <div class="flex justify-center items-center">
                                <a class="flex items-center mr-3 cursor-pointer" target="_blank" href="{{route('proformats.show', $proformat->id)}}">
                                    @icon('show', null, 'mr-2')
                                </a>
                                <a class="flex items-center cursor-pointer" target="_blank"  href="{{route('proformats.pdf', $proformat->id)}}">
                                    @icon('pdf', null, 'mr-2')
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{$proformats->links()}}
        </div>
    </div>




</div>
