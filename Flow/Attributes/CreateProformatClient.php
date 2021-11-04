<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Proformat;

class CreateProformatClient extends Attributes
{

    public function __construct(
        public Proformat $proformat
    ){
      parent::__construct();
    }

    public static function instance(array $value): FlowAttributes
    {
        $proformat = app(ProformatsRepositoryContract::class)->fetchById($value['proformat_id']);
        return new CreateProformatClient($proformat);
    }

    public function toArray(): array
    {
        return [
            'proformat_id' => $this->proformat->id
        ];
    }

    public function getProformat():Proformat
    {
        return $this->proformat;
    }
}
