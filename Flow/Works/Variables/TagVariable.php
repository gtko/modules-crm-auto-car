<?php

namespace Modules\CrmAutoCar\Flow\Works\Variables;

use Modules\CoreCRM\Flow\Works\Variables\WorkFlowVariable;

class TagVariable extends WorkFlowVariable
{

    public function namespace(): string
    {
        return 'tag';
    }

    public function data(array $params = []): array
    {
        /** @var \Modules\CrmAutoCar\Models\Proformat $proformat */
        $tag = $this->event->getData()['tag'];

       return [
         'label' => $tag->label,
       ];
    }

    public function labels(): array
    {
        return [
            'label' => 'label du tag',
        ];
    }
}
