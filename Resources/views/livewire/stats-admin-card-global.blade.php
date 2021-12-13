<div>
    <dl class="mt-5 grid grid-cols-1 rounded-lg bg-white overflow-hidden shadow divide-y divide-gray-200 md:grid-cols-4 md:divide-y-0 md:divide-x">

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Nombre de lead
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-center text-2xl font-semibold text-primary-1">
                    {{ $this->nombreLeads }}
                </div>
            </dd>
        </div>


        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Nombre de contrats
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-center text-2xl font-semibold text-primary-1">
                    {{ $this->nombreContact }}
                </div>
            </dd>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Taux conversion leads / contract
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                    {{ $this->tauxConversion}} %
                </div>
            </dd>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Marge TTC
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                    {{ $this->margeTtc }} €
                </div>
            </dd>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Marge Net
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                    {{ $this->margeNet }} €
                </div>
            </dd>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Pannier Moyen TTC
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                    {{ $this->panierMoyenTtc }} €
                </div>
            </dd>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Prix moyen du lead
            </dt>
            @if (!$this->editPriceLeadActive)
                <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                    <div
                        class="flex items-baseline text-2xl font-semibold text-primary-1 flex-row flex items-baseline justify-between w-full">
                        <div>{{ $leadPrice }} €</div>
                        <div class="text-black cursor-pointer"
                             wire:click="editPriceLead">  @icon('edit', 18, 'ml-2')</div>
                    </div>
                </dd>
            @else

                <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                    <div class="flex flex-row">
                        <x-basecore::inputs.number name="priceLead" wire:model="priceLead" class="form-control-sm"/>
                        <span class="btn-primary p-2 rounded ml-1 cursor-pointer" wire:click="changePriceLead">Save</span>
                    </div>
                </dd>
            @endif


        </div>
        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Shekel / Euro
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                    --
                </div>
            </dd>
        </div>


    </dl>
</div>
