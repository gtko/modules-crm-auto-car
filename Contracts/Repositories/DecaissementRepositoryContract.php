<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Models\Decaissement;


interface DecaissementRepositoryContract
{
    public function create(DevisEntities $devi, Fournisseur $fournisseur, float $payer, float $reste, Carbon $date): Decaissement;
    public function getPayer(DevisEntities $devi, Fournisseur $fournisseur): ?float;
    public function getByDossier(Dossier $dossier): Collection;
    public function getByDevis(): \Illuminate\Support\Collection;
    public function getByFiltre(Fournisseur|string $fournisseur, bool|string $resteAPayer, Carbon|string $periodeStart, Carbon|string $periodeEnd, Carbon|string $deparStart): \Illuminate\Support\Collection;
    public function getTotalResteARegler(array $decaisements):float;
    public function getTotalDejaRegler(array $decaisements):float;
    public function getCountNombrePaiement(Decaissement $decaissement):int;
    public function getDetailPaiement(Decaissement $decaissement): Collection;
}
