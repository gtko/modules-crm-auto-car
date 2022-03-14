@can('viewAny', \Modules\CrmAutoCar\Models\Payment::class)
    <x-basecore::nav.menu-item name="payment">
        <x-basecore::icon-label icon="cash" label="Règlements" :size="20"/>
    </x-basecore::nav.menu-item>
@endcan
