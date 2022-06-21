<?php

namespace Modules\CrmAutoCar\Filters;

use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Traits\EnumStatusCancel;
use Modules\CrmAutoCar\Models\Traits\EnumStatusDemandeFournisseur;

class ProformatFilterQuery
{

    public $repository;
    public $query;

    public function __construct(){
        $this->repository = app(ProformatsRepositoryContract::class);
        $this->query = $this->repository->newQuery();
    }

    public function byBureau(UserEntity $user){
        //on récupère son bureau si il en a un
        $bureaux = $user->roles->whereIn('id', config('crmautocar.bureaux_ids'));
        $this->query->whereHas('devis', function($query) use ($bureaux){
           $query->whereHas('commercial', function($query) use ($bureaux){
               $query->whereHas('roles', function($query) use ($bureaux){
                   $query->whereIn('id', $bureaux->pluck('id'));
               });
           });
        });
    }

    public function ignoreOldCrm(){
        $this->query->whereHas('devis', function($query){
            $query->whereHas('dossier', function($query) {
                $query->whereNotBetween("id", [3585, 22564]);
            });
        });
    }

    public function ignoreAnnuler(){

        $this->query->whereNotIn('status',[EnumStatusCancel::STATUS_CANCELED, EnumStatusCancel::STATUS_CANCELLER]);
    }

    public function withoutFrs($status = 'aucun'){
        if($status !== 'aucun') {
            $this->query->whereHas('devis', function ($query) use ($status) {
                $query->whereHas('demandeFournisseurs', function ($query) use ($status) {
                    $query->where('status', $status);
                });
            });
        }else{
            $this->query->whereHas('devis', function (\Illuminate\Database\Eloquent\Builder $query) {
                $query->whereDoesntHave('demandeFournisseurs', function($query){
                    $query->where('status', EnumStatusDemandeFournisseur::STATUS_BPA);
                    $query->orwhere('status', EnumStatusDemandeFournisseur::STATUS_VALIDATE);
                });
            });
        }
    }

    public function byCommercial(?Commercial $commercial = null)
    {
        if($commercial){
            $this->query->where(function() use ($commercial){
                $this->query->hasCommercial($commercial);
//                $this->query->orWhereHas('devis', function($query) use ($commercial){
//                    $query->whereHas('dossier', function($query) use ($commercial){
//                        $query->whereHas('followers', function($query) use ($commercial){
//                            $query->where('id', $commercial->id);
//                        });
//                    });
//                });
            });
        }
    }

    public function byGestionnaire($user = null)
    {
        if($user){
            $this->query->where(function() use ($user){
                $this->query->WhereHas('devis', function($query) use ($user){
                    $query->whereHas('dossier', function($query) use ($user){
                        $query->whereHas('followers', function($query) use ($user){
                            $query->where('id', $user);
                        });
                    });
                });
            });
        }
    }


    public function byCreatedAt(?Carbon $dateStart = null,?Carbon $dateEnd = null)
    {
        if($dateStart && $dateEnd){
            $this->query->dateReservation($dateStart, $dateEnd);
        }
    }

    public function margeDefinitve(){
        $this->query->whereHas('devis', function($query){
           $query->whereHas('demandeFournisseurs', function($query){
               $query->where('status', EnumStatusDemandeFournisseur::STATUS_BPA);
           });
        });
    }

    public function byMargeEdited(?Carbon $dateStart = null,?Carbon $dateEnd = null)
    {
        if(!$dateStart){
            $dateStart = Carbon::now()->startOfMonth();
        }

        if(!$dateEnd){
            $dateEnd = Carbon::now()->endOfMonth();
        }


        $this->query->whereHas('marges', function($query) use ($dateStart,$dateEnd){
            $query->whereBetween('created_at',[$dateStart,$dateEnd]);
        });

    }

    protected function getPaidIdsProformat(){
        $this->query->with('payments');
        $proformats = $this->query->get();
        return $proformats->filter(function ($proformat) {
            return $proformat->price->paid() === $proformat->price->getPriceTTC();
        })->pluck('id');
    }

    public function paid(){
        $this->query->whereIn('id',$this->getPaidIdsProformat());
    }

    public function notPaid(){
        $this->query->whereNotIn('id',$this->getPaidIdsProformat());
    }


    protected function getContactIdsProformat(){
        $this->query->with('payments');
        $proformats = $this->query->get();
        return $proformats->filter(function ($proformat) {
            return ($proformat->contactFournisseurs()->count() ?? 0) > 0;
        })->pluck('id');
    }

    public function contactChauffeur(){
        $this->query->whereIn('id',$this->getContactIdsProformat());
    }

    public function notContactChauffeur(){
        $this->query->whereNotIn('id',$this->getContactIdsProformat());
    }

    protected function getInfoVoyageIdsProformat(){
        $this->query->with('payments');
        $proformats = $this->query->get();
        return $proformats->filter(function ($proformat) {
            return ($proformat->devis->data['validated'] ?? false);
        })->pluck('id');
    }

    public function infoVoyage(){
        $this->query->whereIn('id',$this->getInfoVoyageIdsProformat());
    }

    public function notInfoVoyage(){
        $this->query->whereNotIn('id',$this->getInfoVoyageIdsProformat());
    }

    public function toInvoice(){
        $this->query->whereHas('devis', function($query){
            $query->doesntHave('invoice');
        })
        ->whereHas('devis', function($query){
            $query->whereHas('dossier', function($query){
                $query->whereHas('status', function($query){
                    $query->where('type',StatusTypeEnum::TYPE_WIN);
                });
            });
        });
    }

    public function query(){
        return $this->query;
    }
}
