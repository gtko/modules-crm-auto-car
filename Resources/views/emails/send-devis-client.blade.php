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
Retrouvez sur le devis devis n°{{ $devis->ref }} :


pour @if($devis->isMultiple) vos transferts @else votre transfert @endif en autocar pour :
<ul>
    @foreach($devis->data['trajets'] as $trajet)
    <li>
        le {{ \Carbon\Carbon::parse($trajet['aller_date_depart'] ?? '')->translatedFormat('d/m/Y') }}
        au départ de {{ $trajet['addresse_ramassage'] ?? ''. ' ' . $trajet['aller_point_depart'] }}
    </li>
    @endforeach
</ul>

Retrouvez votre devis en ligne en cliquant sur le boutton ci-joint.
<br>
@component('mail::button', ['url' => $link, 'color' => 'success'] )
    Voir le devis
@endcomponent

Vous trouverez en piéce jointe le devis au format pdf et les condition général de vente.<br>

Je reste à votre entière disposition pour tout renseignement complémentaire.<br>

Cordialement,<br>

***{{ $devis->dossier->commercial->format_name }}***<br>
{{$devis->dossier->commercial->format_phone}}<br>
{{ $devis->dossier->commercial->email }}<br>
</div>
@endcomponent
