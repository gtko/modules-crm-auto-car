<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;

class DevisSendClient extends Attributes
{

    public function __construct(
        public ?DevisEntities $devis
    ){
      parent::__construct();
    }

    public static function instance(array $value): FlowAttributes
    {
        $devis = app(DevisRepositoryContract::class)->fetchById($value['devis_id'] ?? null);
        return new DevisSendClient($devis);
    }

    public function toArray(): array
    {
        return [
            'devis_id' => $this->devis->id ?? null
        ];
    }

    public function getDevis():DevisEntities
    {
        return $this->devis;
    }
}
