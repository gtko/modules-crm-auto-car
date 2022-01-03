<div>
    <div>
        <div class="overflow-x-auto">
            <table class="table mt-5">
                <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Devis</th>
                    <th class="whitespace-nowrap">validé</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($devis as $devi)
                    <tr>
                        <td class="border-b dark:border-dark-5">
                            {{$devi->ref}}
                        </td>
                        <td class="border-b dark:border-dark-5">
                            --
                        </td>
                        <td class="border-b dark:border-dark-5">
                            {{$devi->data['validated']}}
                        </td>
                        <td class="border-b dark:border-dark-5">
                            <div class="flex justify-center items-center">
                                Voir
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
