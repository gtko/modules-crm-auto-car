<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Repositories\DevisRepository;
use Modules\CrmAutoCar\Actions\CreateInvoice;

class ButtonCreateInvoice extends Component
{

    public $devis_id;

    public function mount(DevisEntities $devis){
        $this->devis_id = $devis->id;
    }

    private function getDevis(){
        $devisRep = app(DevisRepositoryContract::class);
        return $devisRep->fetchById($this->devis_id);
    }

    public function create(){
        $devis = $this->getDevis();
        if(!$devis->invoice()->exists()) {
            (new CreateInvoice())->create($devis);
        }else{
            $this->show();
        }
    }

    public function show(){
        return redirect()->route('invoices.index');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $devis = $this->getDevis();
        return view('crmautocar::livewire.button-create-invoice', [
            'invoice_exist' => $devis->invoice()->exists()
        ]);
    }
}
