<div class=" mb-12">
    <div class=" text-xl font-extrabold uppercase text-center mt-2 mb-2 border border-black bg-gray-400 py-2">
        Voyage n°{{$this->trajetid +1}} - prix forfaitaire t.t.c @marge($price->getPriceTTC())€ <span class="text-sm"> (tva @marge($price->getTauxTVA()) % incluse)</span>
    </div>
    <div class="mx-auto">
        <div class="grid grid-cols-2">
            <span class="py-1 text-sm font-extrabold">Le prix comprend :</span>
            <span class="py-1 text-sm font-extrabold">Frais restant à votre charge :</span>
        </div>
        <div class="grid-cols-2 grid">

            <div class="flex-col flex">
                @if ($this->devis->data['trajets'][$this->trajetid]['inclus_repas_chauffeur'])
                    <span>-Repas chauffeur</span>
                @endif
                @if ($this->devis->data['trajets'][$this->trajetid]['inclus_hebergement'])
                    <span>-Hébergement</span>
                @endif
                @if ($this->devis->data['trajets'][$this->trajetid]['inclus_parking'])
                    <span>-Parking</span>
                @endif
                @if ($this->devis->data['trajets'][$this->trajetid]['inclus_peages'])
                    <span>-Péages</span>
                @endif
            </div>
            <div class="flex-col flex">
                @if (!$this->devis->data['trajets'][$this->trajetid]['inclus_repas_chauffeur'])
                    <span>-Repas chauffeur</span>
                @endif
                @if (!$this->devis->data['trajets'][$this->trajetid]['inclus_hebergement'])
                    <span>-Hébergement</span>
                @endif
                @if (!$this->devis->data['trajets'][$this->trajetid]['inclus_parking'])
                    <span>-Parking</span>
                @endif
                @if (!$this->devis->data['trajets'][$this->trajetid]['inclus_peages'])
                    <span>-Péages</span>
                @endif
            </div>
        </div>
        <div>

        </div>
    </div>
</div>
