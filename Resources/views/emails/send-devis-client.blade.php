@component('mail::message')
<div style="color: black">
<div style="text-align: center">
    <img
        alt="Logo"
        src="{{asset('/assets/img/logo-centrale-autocar.png')}}"
        style="width: 350px; padding-bottom: 50px"
    >
</div>
Bonjour {{ $devis->dossier->client->formatName }}<br><br>

Je vous remercie de l'intérêt que vous portez à Centrale Autocar, votre complice pour tous vos transferts.<br>

Retrouvez sur le devis devis n°{{ $devis->ref }}
pour votre transfert en autocar pour
le {{ \Carbon\Carbon::createFromTimeString($devis->data['aller_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
au départ de {{ $devis->data['addresse_ramassage']. ' ' . $devis->data['aller_point_depart'] }}
en ligne en cliquant sur le boutton ci-joint.
<br>
@component('mail::button', ['url' => $link, 'color' => 'success'] )
    Voir de devis
@endcomponent

Vous trouverez en piéce jointe le devis au format pdf et les condition général de vente.<br>

Je reste à votre entière disposition pour tout renseignement complémentaire.<br>

Cordialement,<br>

***{{ $devis->dossier->commercial->format_name }}***<br>
{{$devis->dossier->commercial->format_phone}}<br>
{{ $devis->dossier->commercial->email }}<br>
</div>
@endcomponent
