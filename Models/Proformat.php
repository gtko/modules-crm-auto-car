<?php

namespace Modules\CrmAutoCar\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ContactFournisseurRepositoryContract;
use Modules\CrmAutoCar\Entities\ProformatPrice;
use Modules\CrmAutoCar\Models\Traits\hasCanceled;
use Modules\CrmAutoCar\Repositories\BrandsRepository;
use Rennokki\QueryCache\Traits\QueryCacheable;
/**
 * @property int $id
 * @property int $devis_id
 * @property string $number
 * @property array $data
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon $acceptation_date
 * @property \Modules\CoreCRM\Contracts\Entities\DevisEntities $devis
 * @property-read \Illuminate\Database\Eloquent\Collection $payments
 * @property-read \Illuminate\Database\Eloquent\Collection $marges
 */
class Proformat extends Model
{
//    use QueryCacheable;
//    protected $cacheFor = 3600;

    const STATUS_CANCELED = 'canceled';
    const STATUS_NORMAL = 'normal';

    use hasCanceled;

    protected $fillable = ['devis_id', 'number', 'total', 'data', 'acceptation_date'];

    public $with = ['marges', 'devis','canceled', 'original'];

    protected $casts = [
        'avoirs' => 'array',
        'data' => 'array',
    ];

    protected $dates = [
        'acceptation_date'
    ];

    public function devis():BelongsTo
    {
        return $this->belongsTo(app(DevisEntities::class)::class, 'devis_id', 'id');
    }

    public function payments():HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function marges():HasMany
    {
        return $this->hasMany(Marge::class);
    }

    public function getPriceAttribute():ProformatPrice
    {
        return (new ProformatPrice($this,  app(BrandsRepositoryContract::class)->getDefault()));
    }

    public function scopeHasCommercial($query, Commercial $commercial){
        return $query->whereHas('devis', function($query) use ($commercial){
            $query->whereHas('dossier', function($query) use ($commercial){
               $query->where('commercial_id', $commercial->id);
            });
        });
    }

    public function scopeDateReservation($query, $dateStart, $dateEnd){
        $query->where(function($q) use ($dateStart, $dateEnd){
            $q->whereNull('acceptation_date');
            $q->whereBetween('created_at',[$dateStart,$dateEnd]);
        });
        $query->orWhere(function($q) use ($dateStart, $dateEnd){
            $q->whereNotNull('acceptation_date');
            $q->whereBetween('acceptation_date',[$dateStart,$dateEnd]);
        });

        return $query;
    }

    public function contactFournisseurs():Collection
    {
        return $this->devis->dossier->contactFournisseurs;
    }

}
