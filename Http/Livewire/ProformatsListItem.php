<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\CoreCRM\Contracts\Services\FlowContract;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Entities\ProformatPrice;
use Modules\CrmAutoCar\Flow\Attributes\ProformatEditMarge;
use Modules\CrmAutoCar\Models\Dossier;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\CrmAutoCar\Repositories\BrandsRepository;
use Modules\DevisAutoCar\Entities\DevisPrice;

class ProformatsListItem extends Component
{

    public $proformat;

    public $marge;
    public $editMargeActive = false;
    public $class = '';

    public function mount(Proformat $proformat, $class = ''){
        $this->proformat = $proformat;

        $price = $this->getPrice();
        $this->marge = $price->getMargeHT();
        $this->class = $class;
    }

    protected function getPrice():ProformatPrice
    {
        $brand = app(BrandsRepositoryContract::class)->getDefault();
        return new ProformatPrice($this->proformat, $brand);
    }

    public function editMarge(){
        $this->editMargeActive = true;
    }

    public function closeMarge(){
        $this->editMargeActive = false;
    }

    public function storeMarge(){
        $this->editMargeActive = false;
        //on sauvegarde la marge avec un historique pour refaire le calcule
        $repProformat = app(ProformatsRepositoryContract::class);
        $marge = $repProformat->addMarge(
            $this->proformat,
            Auth::user(),
            $this->marge
        );

        $dossier = Dossier::find($this->proformat->devis->dossier_id);
        app(FlowContract::class)->add($dossier, new ProformatEditMarge($marge));

        $this->emit('proformats.refresh');
    }


    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('crmautocar::livewire.proformats-list-item', [
            'price' => $this->getPrice()
        ]);
    }
}
