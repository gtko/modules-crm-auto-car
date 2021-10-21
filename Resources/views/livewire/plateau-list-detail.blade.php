<div>
    @foreach($commercialByStatus as $status)
    <div class="text-gray-600 text-xs flex flex-row justify-between items-center py-4">
        <div>{{ $status->first()->status->label }}</div>
        <div class="bg-red-600 text-white p-1 mr-4">{{ count($status)}}</div>
    </div>
    <hr class="mx-2">
    @endforeach
</div>
