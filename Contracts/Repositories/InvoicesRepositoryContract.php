<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
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


    public function statsChiffreAffaire(Carbon $start, Carbon $end):float;
    public function statsNombreFacture(Carbon $start, Carbon $end):float;
    public function statsMargeTotal(Carbon $start, Carbon $end):float;
    public function statsPanierMoyen(Carbon $start, Carbon $end):float;
    public function statsEncaisser(Carbon $start, Carbon $end):float;
    public function statsNonPayer(Carbon $start, Carbon $end):float;
    public function statsTVA(Carbon $start, Carbon $end):float;
    public function statsAvoir(Carbon $start, Carbon $end):float;
    public function statsTropPercu(Carbon $start, Carbon $end):float;

    public function cancel(Invoice $invoice):Invoice;

}
