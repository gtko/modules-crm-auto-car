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
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($salaireDiff)€</div>
                            <div class="text-base text-gray-600 mt-1">Salaire Diff</div>
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

                @can('viewAny', \Modules\CrmAutoCar\Models\Proformat::class)
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="commercial" wire:model="commercialSelect">
                        <option value="" default>Choisissez un commercial</option>
                        @foreach($commercials as $commercial)
                            <option value="{{ $commercial->id }}">{{ $commercial->formatName }}</option>
                        @endforeach
                    </x-basecore::inputs.select>
                </div>
                @endcan

                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="infovoyage" wire:model="infovoyage">
                        <option value="" default>Information voyage</option>
                        <option value="oui">Valide</option>
                        <option value="non">Non valide</option>
                    </x-basecore::inputs.select>
                </div>

                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="paid" wire:model="paid">
                        <option value="" default>Réservation payé</option>
                        <option value="oui">Oui</option>
                        <option value="non">Non</option>
                    </x-basecore::inputs.select>
                </div>

                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="margeEnd" wire:model="margeEnd">
                        <option value="" default>Marge definitive</option>
                        <option value="oui">Oui</option>
                        <option value="non">Non</option>
                    </x-basecore::inputs.select>
                </div>

                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="contact" wire:model="contact">
                        <option value="" default>Contact chauffeur</option>
                        <option value="oui">Oui</option>
                        <option value="non">Non</option>
                    </x-basecore::inputs.select>
                </div>

                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="toinvoice" wire:model="toinvoice">
                        <option value="" default>à facturer</option>
                        <option value="oui">Oui</option>
                    </x-basecore::inputs.select>
                </div>

                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="marge_edited" wire:model="margeEdited">
                        <option value="" default>Voir toutes les réservations</option>
                        <option value="oui">Réservation avec marge modifié</option>
                    </x-basecore::inputs.select>
                </div>
            </div>
        </div>

        <div class="col-span-12 mt-6">
            <div class="block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">Réservations</h2>
            </div>
            <div class="w-full overflow-auto  mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2">
                    <thead>
                        <tr>
                            <x-crmautocar::colsort wire:click="sort('id')"
                                                   class="text-center whitespace-nowrap"
                                                   :active="$order === 'id'"
                                                   :sort="$direction"
                            >
                                #
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('client')"
                                                   class="text-center whitespace-nowrap"
                                                   :active="$order === 'client'"
                                                   :sort="$direction"
                            >
                                Client
                            </x-crmautocar::colsort>
                            <th class="whitespace-nowrap">Etat</th>
                            <th class="whitespace-nowrap">PV / PA</th>
                            <th class="whitespace-nowrap">Marge HT</th>
                            <th class="whitespace-nowrap">Salaire Diff</th>
                            <x-crmautocar::colsort wire:click="sort('fournisseur')"
                                                   class="text-center whitespace-nowrap"
                                                   :active="$order === 'fournisseur'"
                                                   :sort="$direction"
                            >
                                Fournisseur
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('date_depart')"
                                                   class="text-center whitespace-nowrap"
                                                   :active="$order === 'date_depart'"
                                                   :sort="$direction"
                            >
                                Date Départ
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('date_retour')"
                                                   class="text-center whitespace-nowrap"
                                                   :active="$order === 'date_retour'"
                                                   :sort="$direction"
                            >
                                Date Retour
                            </x-crmautocar::colsort>
                            <th class="whitespace-nowrap">Multiple dest</th>
                            <x-crmautocar::colsort wire:click="sort('encaisser')"
                                                   class="text-center whitespace-nowrap"
                                                   :active="$order === 'encaisser'"
                                                   :sort="$direction"
                            >
                                A encaisser
                            </x-crmautocar::colsort>
                            <th class="whitespace-nowrap"></th>
                        </tr>
                    </thead>
                    <tbody wire:loading.remove>
                        @forelse($proformats as $proformat)
                            <livewire:crmautocar::proformats-list-item :key="$proformat->id" :ref="$proformat->id" :proformat="$proformat"/>
                        @empty
                            <tr>
                                <td colspan="11" class="p-5">
                                    <h3 class="text-lg text-gray-600">
                                        <div class="flex justify-start items-center">
                                            @icon('empty', null, 'mr-2')
                                            Aucune réservation trouvée
                                        </div>
                                    </h3>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tbody wire:loading>
                        <tr>
                            <td colspan="11">
                                <div class="text-lg text-gray-600 w-full p-5">
                                    <div class="flex justify-start items-center w-full">
                                        @icon('spinner', null, 'animate-spin mr-2')
                                        Chargement ...
                                    </div>
                                </div>
                            </td>
                        </tr>
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
