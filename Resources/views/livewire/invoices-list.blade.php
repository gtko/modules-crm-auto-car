<div>

    <button wire:click="create(1)">Créer un facture</button>
    ICI ma liste des facture
    <ul>
    @foreach($invoices as $invoice)
        <li>{{$invoice->id}}</li>
    @endforeach
    </ul>
</div>
