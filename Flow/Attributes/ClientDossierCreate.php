<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

class ClientDossierCreate extends \Modules\CoreCRM\Flow\Attributes\ClientDossierCreate
{


    public function getKeyEvent(): string
    {
        return get_class($this);
    }

}
