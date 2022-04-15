<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Entities\ProformatPrice;
use Modules\CrmAutoCar\Models\Proformat;
use Modules\CrmAutoCar\Repositories\BrandsRepository;
use Modules\CrmAutoCar\Services\FilterBureau;

class ProformatsController extends \Modules\CoreCRM\Http\Controllers\Controller
{

    public function __construct(
        public ProformatsRepositoryContract $proformatRep
    ){
        app(FilterBureau::class)->activateFilter();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crmautocar::proformats.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Proformat $proformat
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Proformat $proformat)
    {
        $brand = app(BrandsRepositoryContract::class)->getDefault();
        $price = (new ProformatPrice($proformat, $brand));

        return view('crmautocar::proformats.show', compact('proformat', 'price', 'brand'));
    }

    public function pdf(Proformat $proformat){

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl(route('proformats.show', [$proformat]));
        $pdfService->setParamsBrowser([
            'windowSize'      => [1920, 1000],
            'enableImages'    => true,
        ]);
        $filename = $proformat->number . '-' . Str::slug($proformat->devis->dossier->client->format_name)  . '.pdf';

        return $pdfService->downloadPdf($filename);

    }
}
