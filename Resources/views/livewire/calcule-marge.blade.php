<div class="grid grid-cols-3 gap-4">
    @foreach($proformats as $proformat)

        <div class="rounded shadow bg-white p-3">
            <div>{{$proformat->number}}</div>
            <div class="mb-2">#{{$proformat->id}}</div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Prix de vente</span>  <span>@marge($proformat->price->getPriceVente())€</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Prix d'achat</span>  <span>@marge($proformat->price->getPriceAchatHT(true))€</span>
            </div>

            <div class="flex justify-between items-center">
                <span class="font-bold">Fournisseur</span>  <span>{{$proformat->price->getDemandeFournisseurForMarge()->first()->fournisseur->company ?? 'Aucun'}}</span>
            </div>

            @if($proformat->price->getPriceAchatHT() !== $proformat->price->getPriceAchatHT(true))
                <div class="flex justify-between items-center">
                    <span class="font-bold">Prix d'achat d'origine</span>  <span>@marge($proformat->price->getPriceAchatHT())€</span>
                </div>
            @endif

            <div class="flex justify-between items-center">
                <span class="font-bold">Marge original</span>  <span>@marge($proformat->price->getMargeOriginHT(true))€</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Marge</span>  <span>@marge($proformat->price->getMargeHT())€</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="font-bold">Salaire diff </span>  <span>@marge($proformat->price->getSalaireDiff())€</span>
            </div>

        </div>
    @endforeach

    <div class="rounded shadow p-2 col-span-2">
        <div class="flex justify-between items-center">
            <span class="font-bold">Marge du dossier</span>
            <span>@marge($proformats->map(function($proformat){
                return $proformat->price->getMargeOriginHT();
                })->sum())€
            </span>
        </div>
    </div>

</div>
