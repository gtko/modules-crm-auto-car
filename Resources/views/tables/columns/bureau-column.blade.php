<div class="grid grid-cols-2 gap-1">
    @foreach($getState()->whereIn('id', config('crmautocar.bureaux_ids')) as $bureau)
        <span class="text-xs text-center py-1 px-1 bg-gray-200 whitespace-nowrap overflow-ellipsis rounded">
          {{trim(str_replace('Bureau', '',$bureau->name))}}
        </span>
    @endforeach
</div>
