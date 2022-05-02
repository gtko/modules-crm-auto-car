<div class="intro-y mt-5">
    @if($this->times)
        @if($this->addTime && Auth::user()->isSuperAdmin())
            <div class=" mb-2 grid grid-cols-3 gap-2">
                <div>
                    <x-basecore::inputs.datetime name="modif_date_start" wire:model="modifDateStart" label="Du"/>
                </div>
                <div>
                    <x-basecore::inputs.datetime name="modif_date_end" wire:model="modifDateEnd" label="Au"/>
                </div>
                <div>
                    <x-basecore::loading-replace wire:target="addTime">
                        <x-slot name="loader">
                            <button class="btn btn-primary mt-8 flex items-center space-x-2">
                                @icon('spinner', 20, 'animate-spin mr-2')
                                Ajouter des heures
                            </button>
                        </x-slot>
                        <button class="btn btn-primary mt-8" wire:click="addTime">Ajouter des heures</button>
                    </x-basecore::loading-replace>
                </div>
            </div>
        @endif
        <table class="table bg-white">
            <thead>
            <tr>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Du</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Aux</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap">Total</th>
                <th class="border-b-2 dark:border-dark-5 whitespace-nowrap"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($this->times as $time)
                <tr>
                    <td class="border-b dark:border-dark-5">
                        <span class="flex flex-row items-center">
                            @if (!$timeEdit || ($time->id != $idTime && $timeEdit))
                                {{ $time->start->format('d/m/Y H:i') }}
                            @endif
                            @if(Auth::user()->isSuperAdmin())
                                @if ($timeEdit && $time->id == $idTime)
                                    <x-basecore::inputs.datetime name="date_modif" wire:model="dateModifStart"
                                                                 class="form-control-sm"/>
                                @endif
                            @endif
                        </span>
                    </td>

                    <td class="border-b dark:border-dark-5">
                        <span class="flex flex-row items-center">
                             @if (!$timeEdit || ($time->id != $idTime && $timeEdit))
                                {{ $time->start->addSecond($time->count)->format('d/m/Y H:i')}}
                            @endif
                            @if(Auth::user()->isSuperAdmin())
                                @if (!$timeEdit || ($time->id != $idTime && $timeEdit))
                                    <span class="cursor-pointer"

                                          wire:click="editTime({{$time->id}})">@icon('edit', 18, 'ml-2')</span>
                                @endif
                                @if ($timeEdit && $time->id == $idTime)
                                    <div class="w-72 ml-2 flex flex-row items-center">

                                <x-basecore::inputs.datetime name="date_modif_end" wire:model="dateModifEnd"
                                                             class="form-control-sm"/>

                                <span class="cursor-pointer" wire:click="modifTime({{$time->id}})"
                                      title="modifier">@icon('checkCircle', null, 'ml-1')</span>
                                <span class="cursor-pointer" wire:click="editTime({{$time->id}})"
                                      title="annuler">@icon('close', null, 'mr-2')</span>
                                </div>
                                @endif
                        </span>
                        @endif
                    </td>
                    <td class="border-b dark:border-dark-5">
                        {{ \Carbon\CarbonInterval::second($time->count)->cascade()->forHumans() }}
                    </td>
                    <td class="border-b dark:border-dark-5">
                        @if(Auth::user()->isSuperAdmin())
                            <x-basecore::loading-replace wire:target="delete({{$time->id}})">
                                <span wire:click="delete({{$time->id}})" class="cursor-pointer">
                                    @icon('delete', null, 'mr-2')
                                </span>
                            </x-basecore::loading-replace>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

</div>
