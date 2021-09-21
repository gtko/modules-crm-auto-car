@component('mail::message')


<div style="color: black">
<div style="text-align: center">
<img
alt="Logo"
src="{{asset('/assets/img/logo-centrale-autocar.png')}}"
style="width: 350px; padding-bottom: 50px"
>
</div>
Bonjour Aurelien<br><br>

Je vous remercie de l'intérêt que vous portez à Centrale Autocar, votre complice pour tous vos transferts.<br>

Veuillez trouver le devis n°16336 pour votre transfert en autocar le 10/04/2021 au départ de Reims 51000 en cliquant ici :

@component('mail::button', ['url' => '', 'color' => 'success'] )
Voir de devis
@endcomponent

Je reste à votre entière disposition pour tout renseignement complémentaire.<br>

Cordialement,<br>


***Adrien Valentin***<br>
01 87 21 14 76<br>
<adrien.v@centrale-autocar.com><br>
</div>
@endcomponent
