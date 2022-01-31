<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Marge;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\SearchCRM\Entities\SearchResult;

class ProformatsRepository extends AbstractRepository implements ProformatsRepositoryContract
{

    public function getModel(): Model
    {
        return new Proformat();
    }

    public function getNextNumber(): string
    {
        $proformat = Proformat::orderBy('id', 'DESC')->first();
        $number = last(explode('-', $proformat->number ?? ''));
        $number = (int) str_replace('pf_', '', $number);
        if(!$number){
            $number = 0;
        }

        return Carbon::now()->format('Y').'-'.Carbon::now()->format('m').'-pf_'.(++$number);
    }

    public function create(DevisEntities $devis, float $total, string $number): Proformat
    {
        return Proformat::create(['devis_id' => $devis->id, 'total' => $total, 'number' => $number]);
    }

    public function edit(Proformat $proformat, float $total): Proformat
    {
        $proformat->update(['total' => $total]);
        return $proformat;
    }


    public function updateNumber(Proformat $proformat, string $number): Proformat
    {
        $proformat->update(['number' => $number]);
        return $proformat;
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        return $query->where('number', 'LIKE', '%'.$value.'%');
    }

    public function searchByCommercialAndMonth(Commercial $comercial, int $mount): Collection
    {
        // TODO: Implement searchByCommercialAndMonth() method.
    }


    public function addMarge(Proformat $proformat,UserEntity $user, float $marge): Marge
    {
        return Marge::create([
            'proformat_id' => $proformat->id,
            'user_id' => $user->id,
            'marge' => $marge
        ]);

    }

    public function getLastMarge(Proformat $proformat): float
    {
        return $proformat->marges->last()->marge ?? 0;
    }

    public function hasMargeEdited(Proformat $proformat): bool
    {
        return $proformat->marges->count() > 0;
    }
}
