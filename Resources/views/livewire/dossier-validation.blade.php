<div>
    @push('modals')
        <livewire:basecore::modal
            name="popup-validation-devis"
            :type="Modules\BaseCore\Entities\TypeView::TYPE_LIVEWIRE"
            path='crmautocar::form-validation-devis'
            size="2xl"
        />
    @endpush
    <div>
        <div class="overflow-x-auto">
            <table class="table mt-5">
                <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="whitespace-nowrap">#</th>
                    <th class="whitespace-nowrap">validé</th>
                    <th class="whitespace-nowrap">envoyé</th>
                    <th class="whitespace-nowrap">Actions</th>
                    <i class="bi bi-zoom-out"></i>
                </tr>
                </thead>
                <tbody>
                @foreach($devis as $devi)
                   <livewire:crmautocar::dossier-validation-item :devis="$devi" :key="$devi->id"/>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
