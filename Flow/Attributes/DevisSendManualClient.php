<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;

class DevisSendManualClient extends Attributes
{

    public function __construct(
        public ?DevisEntities $devis
    ){
      parent::__construct();
    }

    public static function instance(array $value): FlowAttributes
    {
        $devis = app(DevisRepositoryContract::class)->fetchById($value['devis_id']);
        return new DevisSendManualClient($devis);
    }

    public function getType(): string
    {
        return static::TYPE_EMAIL;
    }

    public function toArray(): array
    {
        return [
            'devis_id' => $this->devis->id ?? 0
        ];
    }

    public function getDevis():DevisEntities
    {
        return $this->devis;
    }
}
