<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Marge;
use Modules\CrmAutoCar\Models\Proformat;

class ProformatEditMarge extends Attributes
{

    public function __construct(
        public Marge $marge
    ){
      parent::__construct();
    }

    public static function instance(array $value): FlowAttributes
    {
        $marge = Marge::find($value['marge_id']);
        return new ProformatEditMarge($marge);
    }

    public function toArray(): array
    {
        return [
            'marge_id' => $this->marge->id
        ];
    }

    public function getMarge():Marge
    {
        return $this->marge;
    }
}
