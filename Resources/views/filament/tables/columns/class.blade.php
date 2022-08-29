<div>
    <div class="flex p-4 justify-start items-center space-x-4 ">
        <div class="bg-gray-100 border border-gray-200 p-2">
            {{  last(explode('\\', $column->getRecord()->events[0]['class'])) ?? '--' }}
        </div>
        <div class="text-gray-500 font-bold"> -----> </div>
        <div class="bg-blue-100 border border-blue-200 p-2">
            <ul>
            @forelse($column->getRecord()->conditions as $conditions)
                <li>{{  last(explode('\\', $conditions['class'])) ?? '--' }}</li>
            @empty
                <li>Aucune conditions</li>
            @endforelse
            </ul>
        </div>
        <div class="text-gray-500 font-bold"> -----> </div>
        <div class="bg-green-100 border border-green-200 p-2">
            <ul>
            @forelse($column->getRecord()->actions as $action)
                    <li>{{ last(explode('\\', $action['class'])) ?? '--' }}</li>
            @empty
                <li>Aucune actions</li>
            @endforelse
            </ul>
        </div>
    </div>
</div>

