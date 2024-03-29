<?php

namespace Modules\CrmAutoCar\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\PersonneRepositoryContract;
use Modules\BaseCore\Helpers\HasInterface;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\DemandeFournisseurRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\InvoicesRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Marge;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\CrmAutoCar\Models\Traits\EnumStatusCancel;
use Modules\DevisAutoCar\Entities\DevisPrice;
use Modules\SearchCRM\Entities\SearchResult;

class ProformatsRepository extends AbstractRepository implements ProformatsRepositoryContract
{


    public function newQuery(): Builder
    {
        if(Auth::check() && $this->isAllBureau() && !$this->isSearchActivate()) {
            $bureaux = Auth::user()->roles->whereIn('id', config('crmautocar.bureaux_ids'));
            return parent::newQuery()->whereHas('devis', function ($query) use ($bureaux) {
                $query->whereHas('commercial', function ($query) use ($bureaux) {
                    $query->whereHas('roles', function ($query) use ($bureaux) {
                        $query->whereIn('id', $bureaux->pluck('id'));
                    });
                });
            });
        }

        return parent::newQuery();
    }

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

    public function getLastMargeObject(Proformat $proformat, ?Carbon $limit = null): ?Marge
    {
        $marges = $proformat->marges;
        if($limit){
            $marges = $marges->where('created_at', '<=', $limit->endOfDay());
        }

        return $marges->last() ?? null;
    }

    public function getLastMarge(Proformat $proformat, ?Carbon $limit = null): float
    {
        return $this->getLastMargeObject($proformat, $limit)->marge ?? 0;
    }

    public function hasMargeEdited(Proformat $proformat): bool
    {
        return ($proformat->marges->count() ?? 0) > 0 && $proformat->status != EnumStatusCancel::STATUS_CANCELED && $proformat->status != EnumStatusCancel::STATUS_CANCELLER ;
    }

    public function toInvoice(): Collection
    {
       return $this->newQuery()->whereHas('devis', function($query){
           $query->whereHas('dossier', function($query) {
               $query->whereNotBetween("id", [3585, 22564]);
           });
           $query->doesntHave('invoice');
        })
           ->whereHas('devis', function($query){
           $query->whereHas('dossier', function($query){
               $query->whereHas('status', function($query){
                   $query->where('type',StatusTypeEnum::TYPE_WIN);
               });
           });
       })
           ->get();
    }

    public function cancel(Proformat $proforma): Proformat
    {
        DB::beginTransaction();
        $devisRep = app(DevisRepositoryContract::class);

        $devis = $proforma->devis;

        //On duplique le devis
        $duplicateDevis = $devisRep->duplicate($devis);
        $data = $duplicateDevis->data;
        foreach(($data['trajets']  ?? []) as $indexTrajet => $trajet){
            foreach(($trajet['brands'] ?? []) as $indexBrand => $brand){
                $data['trajets'][$indexTrajet]['brands'][$indexBrand] = 0 - ( (int) $data['trajets'][$indexTrajet]['brands'][$indexBrand]);
            }
        }
        $duplicateDevis->data = $data;
        $duplicateDevis->status = EnumStatusCancel::STATUS_CANCELLER;
        $duplicateDevis->save();

        $devis->status = EnumStatusCancel::STATUS_CANCELED;
        $devis->canceled()->associate($duplicateDevis);
        $devis->save();

        $price = new DevisPrice($duplicateDevis, app(BrandsRepositoryContract::class)->getDefault());



        //On créer la proformat negative
        $proformaRep = app(ProformatsRepositoryContract::class);
        $numberProformat = $proformaRep->getNextNumber();
        $newProformat = $proformaRep->create($duplicateDevis, $price->getPriceTTC(), $numberProformat);
        $newProformat->status = EnumStatusCancel::STATUS_CANCELLER;
        $newProformat->save();

        /** @var \Modules\CrmAutoCar\Entities\ProformatPrice $price */
        //On créer des fournisseurs en négatif si il sont validate
        $demandeRep = app(DemandeFournisseurRepositoryContract::class);
        $price = $proforma->price;
        foreach($price->getDemandeFournisseurForMarge() as $demande){
            $demandeRep->cancel($demande, $duplicateDevis);
        }



        //on deplace les paiements sur la nouvelle proformat
        $paiements = $proforma->payments;
        foreach($paiements as $paiement){
            $paiement->proformat_id = $newProformat->id;
            $paiement->save();
        }

        $proforma->status = EnumStatusCancel::STATUS_CANCELED;
        $proforma->canceled()->associate($newProformat);
        $proforma->save();

        DB::commit();

        return $newProformat;
    }

}
