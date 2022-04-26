<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Support\Str;
use Modules\BaseCore\Actions\Url\SigneRoute;
use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\BaseCore\Http\Controllers\Controller;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ContactFournisseurRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\DevisAutocarRepositoryContract;
use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\DevisAutoCar\Entities\DevisPrice;
use Modules\DevisAutoCar\Entities\DevisTrajetPrice;

class InfomationVogageController extends Controller
{
    public function index($devisId, DevisRepositoryContract $devisRep,)
    {
        $devis = $devisRep->fetchById($devisId);
        $brand = Brand::first();

        return view('crmautocar::information-voyage', compact('devis', 'brand'));
    }


    public function pdf($devisId){

        $url = (new SigneRoute())->signer('info-voyage.show', [$devisId]);

        $devis = app(DevisAutocarRepositoryContract::class)->fetchById($devisId);

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl($url);
        $pdfService->setParamsBrowser([
            'windowSize'      => [1920, 1000],
            'enableImages'    => true,
        ]);
        $filename = $devis->ref . '-information-voyage-' . Str::slug($devis->dossier->client->format_name)  . '.pdf';

        return $pdfService->downloadPdf($filename);

    }
}
