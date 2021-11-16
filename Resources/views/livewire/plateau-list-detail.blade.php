<div>
    @if ($commercialByStatus->count() == 0)
        <div class="text-gray-600 flex flex-row justify-between items-center py-4">
            <div>Aucun dossier attribué</div>

        </div>
    @endif
    @foreach($commercialByStatus as $status)
        <div class="text-gray-600 text-xs flex flex-row justify-between items-center py-1">
            <a target="_blank" href="/vue-plateau/{{$modelCommercial->id}}/{{$status->first()->status->id}}">{{ $status->first()->status->label }}</a>
            <div class="text-white p-1 rounded-full">{{ count($status)}}</div>
        </div>

        <livewire:crmautocar::plateau-list-detail-tag :commercialId="$this->commercial_id" :status=" $status->first()->status->label"/>
    @endforeach
</div>
