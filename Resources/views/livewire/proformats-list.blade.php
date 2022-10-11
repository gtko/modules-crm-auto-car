<div>

    @if(!$isBalanced)
        <div class="p-4 mt-4 rounded-md shadow-lg bg-red-50">
            <div class="flex">
                <div class="flex-shrink-0">
                    <!-- Heroicon name: solid/x-circle -->
                    <svg class="w-5 h-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Erreur dans la balance</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul role="list" class="pl-5 space-y-1 list-disc">
                            <li>Certaines proformas annulées ne sont plus à l'équilibres</li>
                            <li>Contacter l'administrateur pour une correction manuel</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div>
        <div class="col-span-12 mt-2 xl:mt-8">
            <div class="grid grid-cols-12 gap-4 mt-2 xl:grid-cols-10 xl:mt-5">
                <div class="col-span-3 xl:col-span-2">
                    <x-crmautocar::widget title="Ventes">
                        @marge($totalVente)€
                    </x-crmautocar::widget>
                </div>
                <div class="col-span-3 xl:col-span-2">
                    <x-crmautocar::widget title="Achats">
                        @marge($totalAchat)€
                    </x-crmautocar::widget>
                </div>
                <div class="col-span-3 xl:col-span-2">
                    <x-crmautocar::widget title="Marge HT" class="text-green-600">
                        @marge($totalMarge)€
                    </x-crmautocar::widget>
                </div>
                <div class="col-span-3 xl:col-span-2">
                    <x-crmautocar::widget title="Marge HT Définitve" class="text-green-600">
                        @marge($totalMargeDefinitive)€
                    </x-crmautocar::widget>
                </div>
                <div class="col-span-3 xl:col-span-2">
                    <x-crmautocar::widget title="A encaisser" class="text-blue-600">
                        @marge($totalEncaissement)€
                    </x-crmautocar::widget>
                </div>
                <div class="col-span-3 xl:col-span-2">
                    <x-crmautocar::widget title="Salaire Diff" class="text-red-600">
                        @marge($salaireDiff)€
                    </x-crmautocar::widget>
                </div>
            </div>
        </div>

        <div class="col-span-12 mt-8">
            <div class="grid grid-cols-12 gap-6 mt-5">

                <div class="col-span-12 ">
                    <x-basecore::inputs.text name="search" wire:model="search" placeholder="Chercher une proforma ... " />
                </div>

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
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <x-basecore::inputs.select name="gestionnaire" wire:model="gestionnaire">
                            <option value="" default>Choisissez un gestionnaire</option>
                            @foreach($gestionnaires as $gestionnaire)
                                <option value="{{ $gestionnaire->id }}">{{ $gestionnaire->formatName }}</option>
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
                    <x-basecore::inputs.select name="salaireDiff" wire:model="salaireDiff">
                        <option value="" default>Salaire Diff</option>
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
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="ignoreoldcrm" wire:model="ignoreoldcrm">
                        <option value="" default>Ignore fiche ancien CRM</option>
                        <option value="oui">Ignorer</option>
                    </x-basecore::inputs.select>
                </div>
                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="statusFrs" wire:model="statusFrs">
                        <option value="" default>Status du Fournisseur</option>
                        <option value="aucun">Aucun</option>
                        @foreach($statusForFrs as $status => $label)
                            <option value="{{$status}}">{{$label}}</option>
                        @endforeach
                    </x-basecore::inputs.select>
                </div>

                <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                    <x-basecore::inputs.select name="canceled" wire:model="canceled">
                        <option value="" default>Voir les annuler</option>
                        <option value="oui">Oui</option>
                    </x-basecore::inputs.select>
                </div>
            </div>
        </div>

        <div class="col-span-12 mt-6">
            <div class="items-center block h-10 sm:flex">
                <h2 class="mr-5 text-lg font-medium truncate">Réservations</h2>
            </div>
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-4 lg:-mx-4">
                <div class="inline-block min-w-full py-2 align-middle">
                    <div class="overflow-hidden shadow-sm ring-1 ring-black ring-opacity-5">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead class="bg-gray-50">
                            <tr class="bg-white rounded shadow">
                                <x-crmautocar::colsort wire:click="sort('id')"
                                                       class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8"
                                                       :active="$order === 'id'"
                                                       :sort="$direction"
                                >
                                    #
                                </x-crmautocar::colsort>
                                <x-crmautocar::colsort wire:click="sort('client')"
                                                       class="whitespace-nowrap w-48 px-3 py-3.5 text-left text-sm font-semibold text-gray-90"
                                                       :active="$order === 'client'"
                                                       :sort="$direction"
                                >
                                    Client
                                </x-crmautocar::colsort>
                                <th class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90">PV / PA</th>
                                <th class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90">Marge HT</th>
                                <th class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90">Salaire Diff</th>
                                <x-crmautocar::colsort wire:click="sort('fournisseur')"
                                                       class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90"
                                                       :active="$order === 'fournisseur'"
                                                       :sort="$direction"
                                >
                                    Fournisseur
                                </x-crmautocar::colsort>
                                <x-crmautocar::colsort wire:click="sort('date_depart')"
                                                       class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90"
                                                       :active="$order === 'date_depart'"
                                                       :sort="$direction"
                                >
                                    Date Départ
                                </x-crmautocar::colsort>
                                <x-crmautocar::colsort wire:click="sort('date_retour')"
                                                       class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90"
                                                       :active="$order === 'date_retour'"
                                                       :sort="$direction"
                                >
                                    Date Retour
                                </x-crmautocar::colsort>
                                <th class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90">Multiple dest</th>
                                <x-crmautocar::colsort wire:click="sort('encaisser')"
                                                       class="px-3 py-3.5 text-left text-sm font-semibold text-gray-90"
                                                       :active="$order === 'encaisser'"
                                                       :sort="$direction"
                                >
                                    A encaisser
                                </x-crmautocar::colsort>
                                <th class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90"></th>
                            </tr>
                        </thead>
                        <tbody wire:loading.remove class="bg-white divide-y divide-gray-200">
                            @forelse($proformats as $proformat)
                                <livewire:crmautocar::proformats-list-item :key="$proformat->id" :ref="$proformat->id" :proformat="$proformat"/>
                            @empty
                                <tr>
                                    <td colspan="11" class="p-5">
                                        <h3 class="text-lg text-gray-600">
                                            <div class="flex items-center justify-start">
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
                                    <div class="w-full p-5 text-lg text-gray-600">
                                        <div class="flex items-center justify-start w-full">
                                            @icon('spinner', null, 'animate-spin mr-2')
                                            Chargement ...
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-gray-50">
                           <tr class="bg-white rounded shadow">
                            <x-crmautocar::colsort wire:click="sort('id')"
                                                   class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8"
                                                   :active="$order === 'id'"
                                                   :sort="$direction"
                            >
                                #
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('client')"
                                                   class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90"
                                                   :active="$order === 'client'"
                                                   :sort="$direction"
                            >
                                Client
                            </x-crmautocar::colsort>
                            <th class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90">PV / PA</th>
                            <th class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90">Marge HT</th>
                            <th class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90">Salaire Diff</th>
                            <x-crmautocar::colsort wire:click="sort('fournisseur')"
                                                   class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90"
                                                   :active="$order === 'fournisseur'"
                                                   :sort="$direction"
                            >
                                Fournisseur
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('date_depart')"
                                                   class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90"
                                                   :active="$order === 'date_depart'"
                                                   :sort="$direction"
                            >
                                Date Départ
                            </x-crmautocar::colsort>
                            <x-crmautocar::colsort wire:click="sort('date_retour')"
                                                   class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90"
                                                   :active="$order === 'date_retour'"
                                                   :sort="$direction"
                            >
                                Date Retour
                            </x-crmautocar::colsort>
                            <th class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90">Multiple dest</th>
                            <x-crmautocar::colsort wire:click="sort('encaisser')"
                                                   class="px-3 py-3.5 text-left text-sm font-semibold text-gray-90"
                                                   :active="$order === 'encaisser'"
                                                   :sort="$direction"
                            >
                                A encaisser
                            </x-crmautocar::colsort>
                            <th class="whitespace-nowrap px-3 py-3.5 text-left text-sm font-semibold text-gray-90"></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                </div>
            </div>
            <div class="mt-2">
            {{$proformats->links()}}
            </div>
        </div>
    </div>

</div>
