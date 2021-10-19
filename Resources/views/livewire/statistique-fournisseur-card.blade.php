<div>
    <div class="col-span-12 mt-8">
        <div class="grid grid-cols-12 gap-6 mt-5">

            <div class="col-span-12  sm:col-span-6 intro-y">
                <div class="report-box zoom-in">
                    <div class="box p-5 text-center">
                        <div class="text-3xl font-medium leading-8 mt-6">{{ $this->resteARegler }}€</div>
                        <div class="text-base text-gray-600 mt-1">Reste à regler</div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 sm:col-span-6 intro-y">
                <div class="report-box zoom-in text-center">
                    <div class="box p-5">
                        <div class="text-3xl font-medium leading-8 mt-6">{{ $this->dejaRegler }}€</div>
                        <div class="text-base text-gray-600 mt-1">Deja Réglé</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
