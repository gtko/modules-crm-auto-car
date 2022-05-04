<div>
    <div>
        <div class="overflow-x-auto">
            <table class="table mt-5">
                <thead>
                <tr class="text-gray-700">
                    <th class="whitespace-nowrap" colspan="6">
                        {{$proformats->count()}} proformas
                    </th>
                </tr>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">Titre devis</th>
                    <th class="whitespace-nowrap">Commercial</th>
                    <th class="whitespace-nowrap">Date</th>
                    <th class="whitespace-nowrap">Accepté</th>
                    <th class="whitespace-nowrap">Total</th>
                    <th class="whitespace-nowrap">Marge HT</th>
                    <th class="whitespace-nowrap">Payé</th>
                    <th class="whitespace-nowrap">Reste</th>
                    <th class="whitespace-nowrap">Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($proformats as $index => $proformat)
                    <livewire:crmautocar::proforma-dossier-detail
                        :proforma="$proformat"
                        :client="$client"
                        :dossier="$dossier"
                        :key="$proformat->id"/>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{$proformats->links()}}
        </div>
    </div>


</div>
