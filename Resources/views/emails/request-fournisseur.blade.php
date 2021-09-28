@component('mail::message')


<div style="color: black">
<div style="text-align: center">
<img
alt="Logo"
src="{{asset('/assets/img/logo-centrale-autocar.png')}}"
style="width: 350px; padding-bottom: 50px"
>
</div>

{{$message}}


</div>
@endcomponent
