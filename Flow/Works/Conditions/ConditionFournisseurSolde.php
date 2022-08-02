<?php

namespace Modules\CrmAutoCar\Flow\Works\Conditions;

use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Flow\Works\Conditions\WorkFlowCondition;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsNombreJours;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsSoldeSelect;
use Modules\CrmAutoCar\Flow\Works\Params\ParamsTypePaiementSelect;
use Modules\CrmAutoCar\Models\DemandeFournisseur;
use Modules\CrmAutoCar\Models\Dossier;
use Modules\DevisAutoCar\Models\Devi;

class ConditionFournisseurSolde extends WorkFlowCondition
{

    public function param(): ?WorkFlowParams
    {
        return new (ParamsSoldeSelect::class);
    }

    public function getValue()
    {
        $data = $this->event->getData();
        $dossier = $data['dossier'];

        $rep = app(DecaissementRepositoryContract::class);
        $decaissements  = $rep->getByDossier($dossier);

        $demandeFournisseur = DemandeFournisseur::whereHas('devis', function($query) use ($dossier){
            $query->whereHas('dossier', function($query) use ($dossier){
                $query->where('id', $dossier->id);
            });
        })->where('status', 'bpa');

        $total = $demandeFournisseur->sum('prix');
        $payer = $decaissements->sum('payer') ?? 0.00;

        if($payer > 0 && $payer < $total){
            return 'partiel';
        }

        if($payer == $total){
            return 'complet';
        }

        return 'aucun';
    }

    public function conditions():array
    {
        return [
            '==' => 'Egal à',
            '!=' => 'Différent de',
        ];
    }

    public function name(): string
    {
        return 'Solde du / des fournisseurs';
    }

    public function describe(): string
    {
        return 'Verifier le solde du/des fournisseurs actuel';
    }
}
