<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Models\Decaissement;
use Modules\CrmAutoCar\Models\DemandeFournisseur;


interface DecaissementRepositoryContract
{
    public function create(DemandeFournisseur $demandeFournisseur, float $payer, float $reste, Carbon $date): Decaissement;
    public function getPayer(DemandeFournisseur $demandeFournisseur): ?float;
    public function getByDossier(Dossier $dossier): Collection;
    public function getByDevis(): \Illuminate\Support\Collection;
    public function getByFiltre(Fournisseur|string $fournisseur, bool|string $resteAPayer, Carbon|string $periodeStart, Carbon|string $periodeEnd, Carbon|string $deparStart): \Illuminate\Support\Collection;
    public function getTotalARegler():float;
    public function getTotalResteARegler():float;
    public function getTotalDejaRegler():float;
    public function getCountNombrePaiement(Decaissement $decaissement):int;
    public function getDetailPaiement(Decaissement $decaissement): Collection;
}
