<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\BaseCore\Helpers\HasInterface;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CrmAutoCar\Models\Dossier;

class DossierAutoCarRepository extends \Modules\CoreCRM\Repositories\DossierRepository
{

    public function getModel(): Model
    {
        return new Dossier();
    }

    public function newQuery(): Builder
    {
        if(Auth::check() && $this->isAllBureau() && !$this->isSearchActivate()) {
            $bureaux = Auth::user()->roles->whereIn('id', config('crmautocar.bureaux_ids'));
            return parent::newQuery()->whereHas('commercial', function ($query) use ($bureaux) {
                $query->whereHas('roles', function ($query) use ($bureaux) {
                    $query->whereIn('id', $bureaux->pluck('id'));
                });
            });
        }

        return parent::newQuery();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        $query = parent::searchQuery($query, $value, $parent);

        if (!HasInterface::has(ClientRepositoryContract::class, $parent)) {
            $query->orWhereHas('client', function ($query) use ($value) {
                return app(ClientRepositoryContract::class)->searchQuery($query, $value, $this);
            });
        }

        return $query;
    }



    public function countDossierResaBlanc(){

        return $this->newQuery()
            ->doesntHave('followers')
            ->whereHas('status', function ($query) {
                $status = app(StatusRepositoryContract::class)->fetchById('8');
                $query->where('order', '>=', $status->order);
                $query->where('order', '<', 800);
                $query->whereIn('type', [StatusTypeEnum::TYPE_CUSTOM]);
            })
            ->count();
    }

}
