<div>
    @if($getState()->date_depart != '' || $getState()->date_retour != '')
            <div
                class="flex bg-gray-100 p-1 rounded flex-col text-xs whitespace-nowrap">
                @if($getState()->date_depart != '') <span>du {{$getState()->date_depart->format('d/m/Y')}}</span> @endif
                @if($getState()->date_retour != '') <span>au {{$getState()->date_retour->format('d/m/Y')}}</span> @endif
            </div>
    @endif
</div>
