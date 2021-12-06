<div>

    <div class="font-extrabold text-center text-lg mt-8">
        Voyage {{ $this->trajetid +1  }}
    </div>
    <div class="border border-black mt-2 max-w-5xl mx-auto">
        <div class="text-center py-2 font-extrabold border border-black">prix @marge($price->getPriceTTC())€</div>
        <div class="grid grid-cols-2" style="background-color: gray">
            <span class="text-center border border-black py-1">Le prix comprend</span>
            <span class="text-center border border-black py-1">Frais restant à votre charge</span>
        </div>
        <div class="grid-cols-2 grid">

            <div class="border border-black flex-col flex p-2 space-y-2">
                @if ($this->devis->data['trajets'][$this->trajetid]['inclus_repas_chauffeur'])
                    <span>Repas chauffeur</span>
                @endif
                @if ($this->devis->data['trajets'][$this->trajetid]['inclus_hebergement'])
                    <span>Hébergement</span>
                @endif
                @if ($this->devis->data['trajets'][$this->trajetid]['inclus_parking'])
                    <span>Parking</span>
                @endif
                @if ($this->devis->data['trajets'][$this->trajetid]['inclus_peages'])
                    <span>Péages</span>
                @endif
            </div>
            <div class="border border-black flex-col flex p-2 space-y-2">
                @if (!$this->devis->data['trajets'][$this->trajetid]['inclus_repas_chauffeur'])
                    <span>Repas chauffeur</span>
                @endif
                @if (!$this->devis->data['trajets'][$this->trajetid]['inclus_hebergement'])
                        <span>Hébergement</span>
                @endif
                @if (!$this->devis->data['trajets'][$this->trajetid]['inclus_parking'])
                        <span>Parking</span>
                @endif
                @if (!$this->devis->data['trajets'][$this->trajetid]['inclus_peages'])
                        <span>Péages</span>
                @endif
            </div>
        </div>
    </div>

    <div class="ml-2 flex flex-col space-y-2 py-2">
        <span class="font-extrabold">Tout changement implique un nouveau devis</span>
        <span>Nombre de véhicule : <span class="font-extrabold">1</span> car(s) afin de transporter <span
                class="font-extrabold">30</span> personnes.</span>
        <span>Planification : <span class="font-extrabold">1</span> Conducteur(s)</span>
        <span class="text-xs pl-16">
                                       <span class="font-bold">14h00 d’amplitude maximum</span>
                                       <span>(pour2 conducteurs/car 18h00 d’amplitude maximum),</span>
                                       <span class="font-bold">celle-ci s’entend départ et retour dépôt.</span>
                                   </span>
    </div>

</div>
