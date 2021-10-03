<div>
    <div class="flex flex-col items-center w-full pb-4" style="background-color: #e8e9eb">
        <img src="/assets/img/logo_devis.png"
             alt=""
             class="my-4 bg-white shadow-2xl"
             style="border: 5px white solid; border-radius: 100%; height: 80px; width:80px;">
        <div class="font-bold">Central Autocar</div>
        <div>
            <span>Validation de votre Devis </span>
            <span class="font-bold">N°12460/16388</span>
        </div>
    </div>
    <form class="space-y-8 divide-y divide-gray-200 p-6" style="background-color: #f5f5f7">
        <div class="space-y-8 divide-y divide-gray-200 sm:space-y-5 px-auto">
            <div class="flex justify-center flex-col items-start">


                <div class="mt-4 sm:mt-4 space-y-2 sm:space-y-3 w-full">
                    <div
                        class="sm:border-t sm:border-gray-200 sm:pt-6">
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                 <span
                                     class="rounded-l-md border border-r-0 sm:text-sm w-2/6 bg-bleu text-white flex items-center justify-center">
                                     Votre nom
                                 </span>
                                <input type="text" name="nom" id="nom" autocomplete="nom" placeholder="Votre nom"
                                       class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 sm:mt-4 space-y-2 sm:space-y-3 w-full">
                    <div
                        class="sm:border-gray-200 sm:pt-2">
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                 <span
                                     class="flex items-center justify-center rounded-l-md sm:text-sm w-2/6 bg-bleu text-white">
                                    Société
                                 </span>
                                <input type="text" name="societe" id="societe" autocomplete="societe"
                                       placeholder="Société"
                                       class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 sm:mt-4 space-y-2 sm:space-y-3 w-full">
                    <div
                        class="sm:border-gray-200 sm:pt-2">
                        <div class="mt-1 sm:mt-0 sm:col-span-2">
                            <div class="max-w-lg flex rounded-md shadow-sm">
                                 <span
                                     class="flex items-center justify-center rounded-l-md sm:text-sm w-2/6 bg-bleu text-white">
                                     Adresse
                                 </span>
                                <input type="text" name="address" id="address" autocomplete="address"
                                       placeholder="Adresse, Cp et Ville"
                                       class="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-none rounded-r-md sm:text-sm border-gray-300">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 sm:pt-5 px-8">
            <div role="group" aria-labelledby="label-notifications">
                <div class="flex flex-col items-start">
                    <div>
                        <div class="text-base font-medium text-gray-900 sm:text-sm sm:text-gray-700 font-bold"
                             id="label-notifications">
                            Mode de paiement souhaité :
                        </div>
                    </div>
                    <div class="sm:col-span-2 mt-0 pt-0">
                        <div class="max-w-lg">
                            <div class="mt-4 space-y-2 ml-2">
                                <div class="flex">
                                    <input id="push-everything" name="push-notifications" type="radio"
                                           class="focus:ring-indigo-500 h-3 w-3 text-indigo-600">
                                    <label for="push-everything"
                                           class="ml-3 block text-sm font-medium text-gray-700">
                                        Virement Bancaire
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="push-email" name="push-notifications" type="radio"
                                           class="focus:ring-indigo-500 h-3 w-3 text-indigo-600">
                                    <label for="push-email"
                                           class="ml-3 block text-sm font-medium text-gray-700">
                                        Chéque
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input id="push-nothing" name="push-notifications" type="radio"
                                           class="focus:ring-indigo-500 h-3 w-3 text-indigo-600">
                                    <label for="push-nothing"
                                           class="ml-3 block text-sm font-medium text-gray-700">
                                        Carte bancaire
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex items-center justify-center">
                        <button type="submit" class="text-2xl text-white px-4 py-2 w-72 rounded mt-4 font-bold"
                                style="background-color: #ffa500;">J'accepte le devis
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="bg-white border border-2 border-black p-4 mt-4 w-full space-y-1">
            <p>
                Merci d'effectuer votre règlement sous 48h par :
            </p>
            <p class="font-bold">
                Virement Bancaire
            </p>
            <p>
                Rib: FR76 3000 4015 9600 0101 0820 195 -
            </p>
            <p>
                BIC: BNPAFRPPXXX
            </p>
            <p class="font-bold">
                Chèque
            </p>
            <p>
                à Centrale Autocar 57 Rue Clisson 75013 Paris
            </p>
            <p class="font-bold">
                Carte Bancaire
            </p>
            <p>
                Par téléphone au 01 87 21 14 76
            </p>
        </div>
    </form>
</div>
