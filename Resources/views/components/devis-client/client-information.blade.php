<div {{ $attributes->merge(['class' => '']) }}>
    <h6 class="text-white bg-bleu text-3xl text-center py-2"
        style="font-family: 'Dancing Script', cursive;">A l'attention de</h6>
    <div class="bg-white border border-2 border-gray-400 p-4">
        <span class="font-bold text-bleu text-base">
            {{ $devis->dossier->client->company ?? '' }}
        </span><br>
        <span class="font-bold text-bleu text-base">
              @if($devis->dossier->client->personne->gender === 'male')
                Monsieur @elseif($devis->dossier->client->personne->gender === 'female') Madame @endif
            {{ $devis->dossier->client->format_name ?? '' }}</span>
    </div>
</div>
