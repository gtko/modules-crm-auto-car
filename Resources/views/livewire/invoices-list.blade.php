<div>

    <button wire:click="create(1)">Créer un facture</button>



    <ul>
    @foreach($invoices as $invoice)
        <li>{{$invoice->id}} - {{$invoice->devis->getTotal()}}€</li>
    @endforeach
    </ul>
</div>
