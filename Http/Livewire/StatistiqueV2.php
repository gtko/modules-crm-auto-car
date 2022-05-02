<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Spatie\Permission\Models\Role;

class StatistiqueV2 extends Component
{

    public $debut = '';
    public $fin = '';
    public $bureau = '';
    public $badge = '';

    public $queryString = ['debut', 'fin'];

    public function mount(){


        if(!$this->debut) {
            $this->debut = now()->startOfMonth()->format('Y-m-d');
        }

        if(!$this->fin) {
            $this->fin = now()->endOfMonth()->format('Y-m-d');
        }

        $this->bureau = '';
        $this->badge = '';

        $this->filtre();
    }


    public function getKeyProperty(){
        return  md5(json_encode($this->filtre));
    }

    public function getFiltreProperty(){
        return [
            'debut' => $this->debut,
            'fin' => $this->fin,
            'bureau' => $this->bureau,
        ];
    }

    public function clear()
    {
        $this->debut = null;
        $this->fin = null;
        $this->badge = '';
        $this->emit('resetCardGlobal', $this->debut, $this->fin);
        $this->emit('dateRange', '', '');
    }

    public function filtre()
    {
        if ($this->debut && $this->fin) {
            $debut = (new DateStringToCarbon())->handle($this->debut);
            $fin = (new DateStringToCarbon())->handle($this->fin);
            $this->badge = 'du ' . $debut->format('d/m/Y') . ' au ' . $fin->format('d/m/Y');
        }
    }

    public function render()
    {

        $bureauxList = Role::whereIn('id', config('crmautocar.bureaux_ids'))->get();

        return view('crmautocar::livewire.statistique-v2', compact('bureauxList'));
    }
}
