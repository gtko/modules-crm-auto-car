<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Carbon;
use Livewire\Component;
use Modules\CrmAutoCar\Models\Invoice;

class CreateAvoir extends Component
{

    public $invoice;
    public $avoir;

    protected $rules = [
        'avoir' => 'required|numeric'
    ];

    public function mount(Invoice $invoice){
        $this->invoice = $invoice;
    }

    public function store(){

        $this->validate();

        $avoirs = $this->invoice->avoirs;
        $avoirs[] = ['avoir' => $this->avoir, 'created_at' => Carbon::now()];
        $this->invoice->avoirs = $avoirs;
        $this->invoice->save();

    }

    public function totalite()
    {

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('crmautocar::livewire.create-avoir', [
            'total' => $this->invoice->total,
            'avoirs' => $this->invoice->avoirs
        ]);
    }
}
