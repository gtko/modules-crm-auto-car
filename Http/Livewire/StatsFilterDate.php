<?php

namespace Modules\CrmAutoCar\Http\Livewire;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Modules\BaseCore\Actions\Dates\DateStringToCarbon;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\TimerCRM\Contracts\Repositories\TimerRepositoryContract;

class StatsFilterDate extends Component
{
    public $mois;
    public $commercial;
    public $badge = '';
    public $debut;
    public $fin;

    protected $listeners = ['updateSelectCommercial', 'resetAll'];

    public function mount()
    {
        if (Auth::user()->hasRole('commercial')) {
            $this->commercial = Auth::commercial();
        }else{
            $this->commercial = app(CommercialRepositoryContract::class)
                ->newQuery()
                ->role('commercial')
                ->first();
        }

    }


    public function updateSelectCommercial(?Commercial $commercial = null)
    {
        $this->commercial = $commercial;
    }

    public function clear()
    {
        $this->mois = null;
        $this->debut = null;
        $this->fin = null;
        $this->badge = '';
        $this->emit('resetCard', $this->commercial, $this->debut, $this->fin);
    }

    public function filtre()
    {
        if ($this->mois && $this->commercial) {

            $date = explode('-', $this->mois);
            $annee = $date[0];
            $mois = $date[1];

            $this->debut = Carbon::createFromDate($annee, $mois)->startOfMonth();
            $this->fin = Carbon::createFromDate($annee, $mois)->endOfMonth();

            $this->emit('dateRange', $this->debut, $this->fin, $this->commercial);
            $this->debut = (new DateStringToCarbon())->handle($this->debut);
            $this->fin = (new DateStringToCarbon())->handle($this->fin);

            $this->badge = 'du ' . $this->debut->format('d/m/Y') . ' au ' . $this->fin->format('d/m/Y');
        }
    }

    public function render()
    {

        $dossier = app(DossierRepositoryContract::class)->newQuery()->orderBy('created_at', 'desc')->first();
        if($dossier) {
            $listMois = CarbonPeriod::create($dossier->created_at, '1 month', Carbon::now());
        }else{
            $listMois = CarbonPeriod::create(Carbon::now()->subYear(), '1 month', Carbon::now());
        }


//        foreach ($listMois as $dt) {
//            dump( $dt->format("Y-m"), $dt->translatedFormat('F Y'));
//        }
//        die();


        return view('crmautocar::livewire.stats-filter-date',
            [
                'listMois' => $listMois,
            ]);
    }
}
