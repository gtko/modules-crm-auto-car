<?php

namespace Modules\CrmAutoCar\Actions;

use Maatwebsite\Excel\Concerns\FromCollection;

class ExportDossier implements FromCollection
{
    public function __construct($records, $model, $livewire = null, $action)
    {
        $this->records = $records;

    }


    public function collection()
    {
        return $this->records->map(function($dossier){
            return [
                'ref' => $dossier->ref,
                'client' => $dossier->client->format_name,
                'société' => $dossier->client->company,
                'commercial' => $dossier->commercial->format_name,
                'date_signature' => $dossier->signature_at,
                'status' => $dossier->status->name,
                'count_devis' => $dossier->devis->count(),
                'date_creation' => $dossier->created_at,
            ];
        });
    }
}
