@component('mail::message')


<div style="color: black">
<div style="text-align: center">
<img
alt="Logo"
src="{{asset('/assets/img/logo-centrale-autocar.png')}}"
style="width: 350px; padding-bottom: 50px"
>
</div>
Bonjour<br><br>

Votre client {{ $devis->dossier->client->formatName }} a validé le devis n°{{ $devis->ref }} au départ de {{ $devis->data['addresse_ramassage'] . ' ' . $devis->data['aller_point_depart'] }} le
    {{ \Carbon\Carbon::createFromTimeString($devis->data['aller_date_depart'] ?? '')->translatedFormat('d/m/Y') }}.<br>

Devis validé le {{ \Carbon\Carbon::now()->format('d/m/Y') }} avec l'ip {{$ip}}

</div>
@endcomponent
