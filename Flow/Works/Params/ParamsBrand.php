<?php

namespace Modules\CrmAutoCar\Flow\Works\Params;

use Modules\CoreCRM\Flow\Works\Interfaces\TypeDataSelect;
use Modules\CoreCRM\Flow\Works\Params\WorkFlowParams;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;

class ParamsBrand extends WorkFlowParams implements TypeDataSelect
{

    public function name(): string
    {
        return 'Brand';
    }

    public function describe(): string
    {
        return '';
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getOptions(): array
    {
        $brands = app(BrandsRepositoryContract::class);
        return $brands->newQuery()->get()->toArray();
    }

    public function getFieldValue($option): string
    {
        return $option["id"];
    }

    public function getFieldLabel($option): string
    {
        return $option["label"];
    }

    function nameView(): string
    {
        return "corecrm::workflows.select";
    }
}
