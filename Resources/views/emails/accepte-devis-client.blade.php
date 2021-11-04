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

Votre devis n°{{ $devis->ref }} pour votre transfert en autocar pour le {{ \Carbon\Carbon::createFromTimeString($devis->data['aller_date_depart'] ?? '')->translatedFormat('d/m/Y') }} au départ de {{ $devis->data['addresse_ramassage'] . ' ' . $devis->data['aller_point_depart'] }} a etait validé.<br>

Vous trouverez en piéce jointe le devis et la facture proformat au format pdf ainsi que les condition général de vente.<br>

Devis validé le {{ \Carbon\Carbon::now()->format('d/m/Y') }}  avec l'ip {{$ip}}

Retrouvez la version en ligne du devis validé

@component('mail::button', ['url' => $devisUrl, 'color' => 'success'] )
    Voir le devis
@endcomponent

Retrouvez la version en ligne de votre facture proformat

@component('mail::button', ['url' => $proformatUrl, 'color' => 'success'] )
    Voir le proformat
@endcomponent

Je reste à votre entière disposition pour tout renseignement complémentaire.<br>

Cordialement,<br>

***{{ $devis->dossier->commercial->format_name }}***<br>
    {{$devis->dossier->commercial->format_phone}}<br>
{{ $devis->dossier->commercial->email }}<br>
</div>
@endcomponent
