<?php

namespace Modules\CrmAutoCar\Http\Livewire\DevisClient;

use Livewire\Component;
use Modules\BaseCore\Http\Livewire\AbstractModal;

class PopupValition extends AbstractModal
{
    public function getKey(): string
    {
        return 'popup-valition';
    }

    public function render()
    {
        return view('crmautocar::livewire.devis-client.popup-valition');
    }
}
