<div>
    <x-basecore::partials.card>
        <form wire:submit.prevent="store" method="POST">

        <div class="flex flex-wrap">
                <x-basecore::inputs.group class="w-full">
                    <x-basecore::inputs.number
                        name="Avoir"
                        label="Avoir"
                        wire:model.defer="avoir"
                        maxlength="255"
                        step="0.01"
                        required="required"
                    />
                    <span class="mt-1 cursor-pointer" wire:click='totalite()'>Totalité (@marge($total)€)</span>
                </x-basecore::inputs.group>
            </div>
            <div class="mt-10">
                <x-basecore::button type="submit">
                    <i class="mr-1 icon ion-md-save"></i>
                    @lang('crud.common.save')
                </x-basecore::button>
            </div>
        </form>

        <table class="divide-y divide-gray-200 w-full mt-4">
            <thead>
            <tr>
                <th scope="col" class="py-3 text-xs font-medium uppercase tracking-wider">Date</th>
                <th scope="col" class="py-3 text-xs font-medium uppercase tracking-wider">Avoir</th>
            </tr>
            </thead>
            <tbody>
                @forelse($avoirs as $avoir)
                    <tr>
                        <td class="py-4 whitespace-nowrap text-sm font-medium text-left">
                            {{Illuminate\Support\Carbon::parse($avoir['created_at'])->format('d/m/Y H:i:s')}}
                        </td>
                        <td class="py-4 whitespace-nowrap text-sm font-medium text-right">
                            @marge($avoir['avoir'])€
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Aucun avoirs</td>
                    </tr>
                @endif
            </tbody>
        </table>

    </x-basecore::partials.card>

</div>
