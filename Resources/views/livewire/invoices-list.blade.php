<div>
        <div class="col-span-12 mt-8">
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart report-box__icon text-theme-24 dark:text-theme-25"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($stats['ca'])€</div>
                            <div class="text-base text-gray-600 mt-1">Chiffre d'affaire</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card report-box__icon text-theme-29"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">{{$stats['nb']}}</div>
                            <div class="text-base text-gray-600 mt-1">Nombre de facture</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor report-box__icon text-theme-15"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($stats['marge'])€</div>
                            <div class="text-base text-gray-600 mt-1">Marge Total</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user report-box__icon text-theme-20"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($stats['panier_moyen'])€</div>
                            <div class="text-base text-gray-600 mt-1">Panier moyen</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user report-box__icon text-theme-20"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($stats['encaisser'])€</div>
                            <div class="text-base text-gray-600 mt-1">Encaissé</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user report-box__icon text-theme-20"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($stats['non_payer'])€</div>
                            <div class="text-base text-gray-600 mt-1">Non payé</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <div class="report-box zoom-in">
                        <div class="box p-5">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user report-box__icon text-theme-20"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            </div>
                            <div class="text-3xl font-medium leading-8 mt-6">@marge($stats['tva'])€</div>
                            <div class="text-base text-gray-600 mt-1">TVA</div>
                        </div>
                    </div>
                </div>

                @if($stats['trop_percu'] > 0)
                    <div class="col-span-12 text-white sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box bg-red-100 shadow-lg p-5">
                                <div class="flex text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user report-box__icon text-red-700"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </div>
                                <div class="text-3xl text-red-700 font-medium leading-8 mt-6">@marge($stats['trop_percu'])€</div>
                                <div class="text-base text-red-700 mt-1">Trop perçu</div>
                            </div>
                        </div>
                    </div>
                @endif

                @if($stats['to_invoice'] > 0)
                    <a href="{{route('proformats.index', ['toinvoice' => 'oui'])}}" class="col-span-12 text-white sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box bg-red-100 shadow-lg p-5">
                                <div class="flex text-red-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user report-box__icon text-red-700"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                </div>
                                <div class="text-3xl text-red-700 font-medium leading-8 mt-6">{{$stats['to_invoice']}}</div>
                                <div class="text-base text-red-700 mt-1">à facturer</div>
                            </div>
                        </div>
                    </a>
                @endif
            </div>
        </div>


    <div class="col-span-12 mt-8">
        <div class="grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 sm:col-span-6 xl:col-span-6 intro-y">
                <div class="flex space-x-2">
                    <x-basecore::inputs.date name='start' wire:model="start"/>
                    <x-basecore::inputs.date name='end' wire:model="end"/>
                </div>
            </div>

            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                <x-basecore::inputs.select name="status" wire:model="status">
                    <option value="" default>Facture status</option>
                    <option value="solder">Entièrement soldé</option>
                    <option value="pas_solder">Pas soldé</option>
                    <option value="trop_percu">Trop perçu</option>
                </x-basecore::inputs.select>
            </div>

        </div>
    </div>

        <div class="col-span-12 mt-6">
            <div class="intro-y block sm:flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">Factures</h2>
            </div>
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2">
                    <thead>
                    <tr>
                        <th class="whitespace-nowrap">#</th>
                        <th class="whitespace-nowrap">Client</th>
                        <th class="text-center whitespace-nowrap">Montant HT</th>
                        <th class="text-center whitespace-nowrap">TVA</th>
                        <th class="text-center whitespace-nowrap">Montant TTC</th>
                        <th class="text-center whitespace-nowrap">Reste TTC</th>
                        <th class="text-center whitespace-nowrap">Trop Perçu</th>
                        <th class="text-center whitespace-nowrap">Status</th>
                        <th class="text-center whitespace-nowrap"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($invoices as $invoice)
                        <livewire:crmautocar::invoices-list-item :key="$invoice->id" :ref="$invoice->id" :invoice="$invoice" />
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{$invoices->links()}}

        </div>
</div>
