<?php

namespace Modules\CrmAutoCar\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\SearchCRM\Entities\SearchResult;

class Client extends \Modules\CoreCRM\Models\Client
{

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
