<div class="intro-y mt-5">
    @if($this->times)
        <table class="table bg-white">
            <thead>
            <tr>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Du</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Aux</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->times as $time)
                <tr>
                    <td class="border-b dark:border-dark-5">
                        {{ $time->start->format('d/m/Y H:i') }}
                    </td>
                    <td class="border-b dark:border-dark-5">
                        <span class="flex flex-row items-center">
                            {{ $time->start->addSecond($time->count)->format('d/m/Y H:i')}}
                            <span class="cursor-pointer" wire:click="editTime({{$time->id}})">@icon('edit', 18, 'ml-2')</span>
                            @if ($timeEdit && $time->id == $idTime)
                                <div class="w-72 ml-2 flex flex-row items-center">
                                <x-basecore::inputs.datetime name="date_modif" wire:model="dateModif"/>
                                <span class="cursor-pointer" wire:click="modifTime({{$time->id}})" title="modifier">@icon('checkCircle', null, 'ml-1')</span>
                                <span class="cursor-pointer" wire:click="editTime({{$time->id}})" title="annuler">@icon('close', null, 'mr-2')</span>
                                </div>
                            @endif
                        </span>
                    </td>
                    <td class="border-b dark:border-dark-5">
                        {{ \Carbon\CarbonInterval::second($time->count)->cascade()->forHumans() }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

</div>
