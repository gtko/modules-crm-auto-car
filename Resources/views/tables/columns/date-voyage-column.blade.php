<div class="grid grid-cols-2 gap-1">
    @foreach($getState()->where('validate', true) as $devi)
        @if($devi->date_depart != '' || $devi->date_retour != '')
            <div
                class="flex bg-gray-100 p-1 rounded flex-col text-xs whitespace-nowrap @if($getState()->where('validate', true)->count() > 1) mb-1 @endif">
                @if($devi->date_depart != '') <span>du {{$devi->date_depart->format('d/m/Y')}}</span> @endif
                @if($devi->date_retour != '') <span>au {{$devi->date_retour->format('d/m/Y')}}</span> @endif
            </div>
        @endif

    @endforeach
</div>
