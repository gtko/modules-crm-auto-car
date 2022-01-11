<div>

    <div>
        <div class="col-span-12 mt-8">
            <div class="grid grid-cols-12 gap-6 mt-5">

                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-shopping-cart report-box__icon text-theme-24 dark:text-theme-25">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($totalVente)€</div>
                            <div class="text-base text-gray-600 mt-1">Total des ventes</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-credit-card report-box__icon text-theme-29">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($totalAchat)€</div>
                            <div class="text-base text-gray-600 mt-1">Total Achat</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-monitor report-box__icon text-theme-15">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                                    <line x1="8" y1="21" x2="16" y2="21"></line>
                                    <line x1="12" y1="17" x2="12" y2="21"></line>
                                </svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($totalMarge)€</div>
                            <div class="text-base text-gray-600 mt-1">Total Marge HT</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round"
                                     class="feather feather-user report-box__icon text-theme-20">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($totalEncaissement)€</div>
                            <div class="text-base text-gray-600 mt-1">Total à encaisser</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-span-12 mt-8">
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="mois" wire:model="mois">
                        <option value="" default>Choisissez un mois</option>
                        @foreach($byMois as $mois)
                            <option value="{{$mois->format('d/m/Y')}}">{{$mois->format('M Y')}}</option>
                        @endforeach
                    </x-basecore::inputs.select>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="commercial" wire:model="commercialSelect">
                        <option value="" default>Choisissez un commercial</option>
                        @foreach($commercials as $commercial)
                            <option value="{{ $commercial->id }}">{{ $commercial->formatName }}</option>
                        @endforeach
                    </x-basecore::inputs.select>
                </div>
            </div>
        </div>

        <div class="col-span-12 mt-6">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">Réservations</h2>
            </div>
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2">
                    <thead>
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">Client</th>
                        <th class="whitespace-nowrap">Etat</th>
                        <th class="whitespace-nowrap">PV / PA</th>
                        <th class="whitespace-nowrap">Marge HT</th>
                        <th class="whitespace-nowrap">Fournisseur</th>
                        <th class="whitespace-nowrap">Date Départ</th>
                        <th class="whitespace-nowrap">Date Retour</th>
                        <th class="whitespace-nowrap">A encaisser</th>
                        <th class="whitespace-nowrap"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($proformats as $proformat)
                        <livewire:crmautocar::proformats-list-item :key="$proformat->id" :ref="$proformat->id" :proformat="$proformat"/>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">Client</th>
                        <th class="whitespace-nowrap">Etat</th>
                        <th class="whitespace-nowrap">PV / PA</th>
                        <th class="whitespace-nowrap">Marge HT</th>
                        <th class="whitespace-nowrap">Fournisseur</th>
                        <th class="whitespace-nowrap">Date Départ</th>
                        <th class="whitespace-nowrap">Date Retour</th>
                        <th class="whitespace-nowrap">A encaisser</th>
                        <th class="whitespace-nowrap"></th>
                    </tr>
                    </tfoot>
                </table>
            </div>

            {{$proformats->links()}}

        </div>
    </div>

</div>
