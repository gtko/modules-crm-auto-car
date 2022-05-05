<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\SearchCRM\Entities\SearchResult;

class Client extends \Modules\CoreCRM\Models\Client
{

    protected static function booted()
    {
        static::addGlobalScope('signature_at', function (Builder $builder) {
            $builder->select('*');
            $builder->selectSub(DB::query()->select('proformats.created_at')
                ->from('devis')
                ->join('proformats', 'devis.id', '=', 'proformats.devis_id')
                ->join('dossiers', 'devis.dossier_id', '=', 'dossiers.id')
                ->whereColumn('dossiers.clients_id', 'clients.id')
                ->orderBy('proformats.created_at', 'asc')
                ->limit(1), 'signature_at');
        });
    }

    public function getSearchResult(): SearchResult
    {
        $result = new SearchResult(
            $this,
            $this->format_name . ' - ' . ($this->company  ?? "N/A"),
            route('clients.show', $this->id),
            'clients',
            html:"<small>{$this->email}</small> - <small>{$this->phone}</small>"
        );
        $result->setImg($this->avatar_url);
        return $result;
    }

}
