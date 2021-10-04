<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\BaseCore\Interfaces\RepositoryQueryCustom;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\SearchCRM\Interfaces\SearchableRepository;

interface InvoicesRepositoryContract extends SearchableRepository, RepositoryFetchable, RepositoryQueryCustom
{

    public function getNextNumber():string;

    public function create(DevisEntities $devis, float $total, string $number):Invoice;
    public function edit(Invoice $invoice, float $total):Invoice;

    public function addAvoir(Invoice $invoice,float $total):Invoice;
    public function updateNumber(Invoice $invoice,string $number):Invoice;

}
