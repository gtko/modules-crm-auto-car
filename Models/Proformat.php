<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Models\Commercial;
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
 */
class Proformat extends Model
{

    protected $fillable = ['devis_id', 'number', 'total', 'data'];

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


    protected function brandCached():Brand
    {
        return Cache::remember('cache_brand_default', 60, function(){
            return app(BrandsRepository::class)->fetchById(config('crmautocar.brand_default'));
        });
    }

    public function getPriceAttribute():ProformatPrice
    {
        return (new ProformatPrice($this, $this->brandCached()));
    }

    public function scopeHasCommercial($query, Commercial $commercial){
        return $query->whereHas('devis', function($query) use ($commercial){
            $query->whereHas('dossier', function($query) use ($commercial){
               $query->where('commercial_id', $commercial->id);
            });
        });
    }

}
