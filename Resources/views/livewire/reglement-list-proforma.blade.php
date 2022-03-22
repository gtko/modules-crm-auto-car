<div class="rows">
    <div class="col-md-12">
        <div class="table-section clearfix">
            <div class="table-responsive">
                <table class="table invoice-table">
                    <thead class="bg-active">
                    <tr>
                        <th>Paiements</th>
                        <th class="text-right"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($paiements->count() > 0)
                    @foreach($paiements as $paiement)
                        <tr>
                            @switch(($paiement->data['type'] ?? ''))
                                @case('virement')
                                <td>Réglement le {{$paiement->created_at->format('d/m/Y')}} par virement</td>
                                @break
                                @case('cheque')
                                <td>Réglement le {{$paiement->created_at->format('d/m/Y')}} par chèque</td>
                                @break
                                @case('carte')
                                <td>Réglement le {{$paiement->created_at->format('d/m/Y')}} par carte bancaire</td>
                                @break
                                @case('remboursement')
                                <td>Remboursement le {{$paiement->created_at->format('d/m/Y')}}</td>
                                @break
                                @case('avoir')
                                <td>Avoir le {{$paiement->created_at->format('d/m/Y')}}</td>
                                @break
                                @default
                                <td>Réglement le {{$paiement->created_at->format('d/m/Y')}}</td>
                            @endswitch
                            <td>@marge($paiement->total)€</td>
                        </tr>
                    @endforeach
                    @else
                        <tr>
                            <td colspan="2">Aucun réglement enregistré.</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
