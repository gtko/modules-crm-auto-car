<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\HydrationMiddleware\HydratePublicProperties;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;
use Modules\CrmAutoCar\Models\DemandeFournisseur;
use phpDocumentor\Reflection\Types\Parent_;

class DecaissementRepository extends AbstractRepository implements DecaissementRepositoryContract
{

    public function newQuery():Builder
    {
        if(Auth::check() && $this->isAllBureau() && !$this->isSearchActivate()) {
            $bureaux = Auth::user()->roles->whereIn('id', config('crmautocar.bureaux_ids'));
            return parent::newQuery()->whereHas('devis', function ($query) use ($bureaux) {
                $query->whereHas('commercial', function ($query) use ($bureaux) {
                    $query->whereHas('roles', function ($query) use ($bureaux) {
                        $query->whereIn('id', $bureaux->pluck('id'));
                    });
                });
            });
        }

        return parent::newQuery();
    }

    public function create(DemandeFournisseur $demandeFournisseur, float $payer, float $reste, Carbon $date): Decaissement
    {

        $decaissement = new Decaissement();
        $decaissement->payer = $payer;
        $decaissement->restant = $reste;
        $decaissement->date = $date;
        $decaissement->demande()->associate($demandeFournisseur);
        $decaissement->devis()->associate($demandeFournisseur->devis);
        $decaissement->fournisseur()->associate($demandeFournisseur->fournisseur);
        $decaissement->save();

        return $decaissement;
    }

    public function getPayer(DemandeFournisseur $demandeFournisseur): ?float
    {
        $paiements = Decaissement::where('demande_id', $demandeFournisseur->id)->get();
        $dejaPayer = 0;
        foreach ($paiements as $paiement) {
            $dejaPayer = $dejaPayer + $paiement->payer;
        }

        return $dejaPayer;
    }

    public function getByDossier(Dossier $dossier): Collection
    {
        return $this->newQuery()->whereHas('devis', function ($query) use ($dossier) {
            $query->whereHas('dossier', function ($query) use ($dossier) {
                $query->where('id', $dossier->id);
            });
        })->get();
    }

    public function getByDevis(): \Illuminate\Support\Collection
    {
        return $this->getAllDevisFournisseur();
    }

    public function getByFiltre(Fournisseur|string $fournisseur, bool|string $resteAPayer, Carbon|string $periodeStart, Carbon|string $periodeEnd, Carbon|string $deparStart): \Illuminate\Support\Collection
    {
        $query = app(FournisseurRepositoryContract::class)
            ->newQuery()
            ->has("devis")
            ->with('devis.decaissements');

        if ($fournisseur !== '') {
            $query->where('id', $fournisseur->id);
        }



        if ($resteAPayer !== '') {
            if($resteAPayer === 'troppayer'){
                $query->whereHas('devis', function($query){
                    $query->whereHas('decaissements', function($query){
                        $query->where('restant', '<', 0);
                    });
                });
            }else {
                if ($resteAPayer) {
                    $query->whereHas('devis', function($query){
                        $query->whereHas('decaissements', function($query){
                            $query->where('restant', '>', 0);
                        });
                        $query->orWhereDoesntHave('decaissements');
                    });
                } else {
                    $query->whereHas('devis', function($query){
                        $query->whereHas('decaissements', function($query){
                            $query->where('restant', 0);
                        });
                    });
                }
            }
        }

        if ($periodeStart !== '' && $periodeEnd !== '') {
            $query->whereHas('devis', function($query) use ($periodeStart, $periodeEnd){
                $query->whereHas('decaissements', function($query) use ($periodeStart, $periodeEnd){
                    $query->whereBetween('date', [$periodeStart, $periodeEnd]);
                });
            });
        }


        $devis = $query->get()
            ->map(function($fournissuer){
                return $fournissuer->devis;
            })
            ->flatten();

        if ($deparStart !== '') {
            $devis = $devis->filter(function($devi) use ($deparStart){
                return isset($devi->data['trajets'][0]['aller_date_depart']) &&
                    Carbon::createFromTimeString($devi->data['trajets'][0]['aller_date_depart'])->between(
                        $deparStart,
                        $deparStart->copy()->endOfDay()
                    );
            });
        }

        return $devis;
    }

    protected function getAllDevisFournisseur(){
        return Cache::remember('getAllDevisFournisseur', '10', function(){
            $result = app(FournisseurRepositoryContract::class)
                ->newQuery()
                ->has("devis")
                ->with('devis.decaissements')
                ->get()
                ->map(function($fournisseur){
                    return $fournisseur->devis;
                })
                ->flatten();

            return $result;
        });
    }

    protected function getAllDecaisement(){
        return Cache::remember('getAllDevisFournisseur', '10', function(){
            $devis = $this->getAllDevisFournisseur();
            return $this->newQuery()->with('devis')->whereIn('devis_id', $devis->pluck('id'))->get();
        });
    }

    public function getTotalARegler(): float
    {
        $devis = $this->getAllDevisFournisseur();
        $total = $devis->sum('pivot.prix') ?? 0.00;
        if($total > 0){
            return $total;
        }

        return 0;
    }

    public function getTotalResteARegler(): float
    {
        $devisPayer = $this->getAllDecaisement();
        $restant = $devisPayer->sum('restant') ?? 0.00;
        if($restant > 0){
            return $restant;
        }

        return 0;
    }

    public function getTotalDejaRegler(): float
    {
        $devisPayer = $this->getAllDecaisement();
        return $devisPayer->sum('payer') ?? 0.00;
    }

    public function getCountNombrePaiement(Decaissement $decaissement): int
    {
        return $this->newQuery()->where('fournisseur_id', $decaissement->fournisseur_id)->where('devis_id', $decaissement->devis_id)->count();
    }

    public function getDetailPaiement(Decaissement $decaissement): Collection
    {
        return $this->newQuery()->where('fournisseur_id', $decaissement->fournisseur_id)->where('devis_id', $decaissement->devis_id)->get();
    }

    public function getModel(): Model
    {
        return new Decaissement();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query;
    }
}
