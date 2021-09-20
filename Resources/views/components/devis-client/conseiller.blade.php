<div {{ $attributes->merge(['class' => '']) }}>
    <h6 class="font-bold text-sm pb-2">Des questions ?</h6>
    <span>
                    <span>Notre équipe ainsi que votre conseiller dédié</span>
                    <span class="font-bold">{{ $devis->dossier->commercial->format_name }}</span>
                    <span>est ravie de vous aider au :</span>
                    <br>
                    <span class="text-red-500 font-bold"><a href="tel:{{$devis->dossier->commercial->phone}}"
                                                            class="ignore-link">{{ $devis->dossier->commercial->format_phone }}</a></span>

                </span>
</div>
