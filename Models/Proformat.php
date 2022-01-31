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
use Modules\CrmAutoCar\Repositories\BrandsRepository;

/**
 * @property int $id
 * @property int $devis_id
 * @property string $number
 * @property array $data
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Modules\CoreCRM\Contracts\Entities\DevisEntities $devis
 * @property-read \Illuminate\Database\Eloquent\Collection $payments
 * @property-read \Illuminate\Database\Eloquent\Collection $marges
 */
class Proformat extends Model
{

    protected $fillable = ['devis_id', 'number', 'total', 'data'];

    public $with = ['marges', 'devis'];

    protected $casts = [
        'avoirs' => 'array',
        'data' => 'array',
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

    public function contactFournisseurs():Collection
    {
        return $this->devis->dossier->contactFournisseurs;
    }

}
