<?php

namespace Modules\CrmAutoCar\View\Components;

use Illuminate\View\Component;

class PaymentLabelTab extends Component
{

    public function __construct(Public $client, public $dossier){}

    public function render()
    {
        return view('crmautocar::components.payment-label-tab');
    }
}
