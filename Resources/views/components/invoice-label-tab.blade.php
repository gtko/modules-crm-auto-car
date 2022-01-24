@can('viewAny', \Modules\CrmAutoCar\Models\Invoice::class)
<x-basecore::nav.menu-item name="invoices">
    <x-basecore::icon-label icon="invoice" label="Factures" :size="20"/>
</x-basecore::nav.menu-item>
@endcan
