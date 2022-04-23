@props([
    'sort' => null,
    'active' => false
])

<th>
    <div @if($sort ) {{$attributes->merge(['class' => 'whitespace-nowrap flex cursor-pointer items-center justify-start'])}} @endif>
        {{$slot}}
        @if($active && $sort === 'asc')
            <span class="ml-2">@icon('asc', 16, 'mr-2')</span>
        @elseif($active &&  $sort === 'desc')
            <span class="ml-2">@icon('desc', 16, 'mr-2')</span>
        @elseif(!$active ||  $sort === '--')
            <span class="ml-2">--</span>
        @endif
    </div>
</th>
