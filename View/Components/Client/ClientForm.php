<?php

namespace Modules\CrmAutoCar\View\Components\Client;

use Illuminate\View\Component;
use Modules\BaseCore\Models\Country;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Models\Client;

class ClientForm extends Component
{

    public function __construct(
        public ?ClientEntity $client = null
    ){}

    /**
     * Get the views / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {


        $countries = Country::all();

        return view('crmautocar::components.client.form', [
            'editing' => $this->client->id,
            'personne' => $this->client,
            'countries' => $countries
        ]);
    }
}
