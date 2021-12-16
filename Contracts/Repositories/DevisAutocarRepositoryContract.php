<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Models\Fournisseur;

interface DevisAutocarRepositoryContract extends DevisRepositoryContract
{
    public function bpaFournisseur(DevisEntities $devis, Fournisseur $fournisseur, bool $bpa = true);
}
