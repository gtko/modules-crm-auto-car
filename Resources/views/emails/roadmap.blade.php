@component('mail::message')


<div style="color: black">
<div style="text-align: center">
<img
alt="Logo"
src="{{asset('/assets/img/logo-centrale-autocar.png')}}"
style="width: 350px; padding-bottom: 50px"
>

</div>
Veuillez trouvez ci-joint votre feuille de route.<br><br>


<div style="color: red; font-size: 18px; text-decoration: underline; font-weight: bold; text-align: center; margin-bottom: 2rem">Dossier conducteur</div>

<div style="font-weight: bold; margin-bottom: 1rem">
<span>Date de départ : </span>
<span>24/10/2020</span>
</div>

<div style="font-weight: bold; margin-bottom: 2rem">
<span>Heure de départ : </span>
<span>20:00</span>
</div>

<div style="font-weight: bold; margin-bottom: 1rem">
<span>Lieu de départ : </span>
<span>Aréna de Narbonne</span>
</div>
<div style="font-weight: bold; margin-bottom: 1rem">
<span>Heure de départ : </span>
<span>20:00</span>
</div>


{{-- @todo numero de chauffeur allé / Retour --}}

Cordialement,<br>


***Adrien Valentin***<br>
01 87 21 14 76<br>
<adrien.v@centrale-autocar.com><br>
</div>
@endcomponent
