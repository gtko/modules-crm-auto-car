<div>
    <dl class="mt-5 grid grid-cols-1 rounded-lg bg-white overflow-hidden shadow divide-y divide-gray-200 md:grid-cols-4 md:divide-y-0 md:divide-x">

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Nombre d'heure de travail
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-center text-2xl font-semibold text-primary-1">
                    {{ $this->nombeHeureTravail }}
                </div>
            </dd>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Taux horaire
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-center text-2xl font-semibold text-primary-1">
                    @marge($this->tauxHoraire)€
                </div>
            </dd>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Nombre de lead
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-center text-2xl font-semibold text-primary-1">
                    {{ $this->nombreLead }}
                </div>
            </dd>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Nombre de contrats
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-center text-2xl font-semibold text-primary-1">
                   {{ $this->nombreContrat }}
                </div>
            </dd>
        </div>

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Taux conversion leads / contrats
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                    @marge($this->tauxConversion)%
                </div>
            </dd>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Marge TTC
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                    @marge($this->margeTtc)€
                </div>
            </dd>
        </div>
        @if(Auth::user()->isSuperAdmin())
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-base font-normal text-gray-900">
                    Marge Net
                </dt>
                <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                    <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                        @marge($this->margeNet)€
                    </div>
                </dd>
            </div>
        @endif

        <div class="px-4 py-5 sm:p-6">
            <dt class="text-base font-normal text-gray-900">
                Panier moyen TTC
            </dt>
            <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                    @marge($this->panierMoyenTtc)€
                </div>
            </dd>
        </div>
        @if(Auth::user()->isSuperAdmin())
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-base font-normal text-gray-900">
                    Panier moyen net
                </dt>
                <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                    <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                        @marge($this->panierMoyenNet)€
                    </div>
                </dd>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-base font-normal text-gray-900">
                    Marge net Aprés horaire
                </dt>
                <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                    <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                        @marge($this->margeNetAfterHoraire)€
                    </div>
                </dd>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <dt class="text-base font-normal text-gray-900">
                    Panier moyen Net Aprés horaires
                </dt>
                <dd class="mt-1 flex justify-between items-baseline md:block lg:flex">
                    <div class="flex items-baseline text-2xl font-semibold text-primary-1">
                        @marge($this->panierMoyenAfterHoraire)€
                    </div>
                </dd>
            </div>
        @endif

    </dl>
</div>
