<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\CrmAutoCar\Entities\ProformatPrice;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\CrmAutoCar\Repositories\BrandsRepository;
use Modules\DevisAutoCar\Entities\DevisPrice;

class ProformatsListItem extends Component
{

    public $proformat;

    public function mount(Proformat $proformat){
        $this->proformat = $proformat;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        $brand = app(BrandsRepository::class)->fetchById(config('crmautocar.brand_default'));

        return view('crmautocar::livewire.proformats-list-item', [
            'price' => new ProformatPrice($this->proformat, $brand)
        ]);
    }
}
