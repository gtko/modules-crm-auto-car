<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\BaseCore\Actions\Url\SigneRoute;
use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\BaseCore\Http\Controllers\Controller;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Entities\InvoicePrice;
use Modules\CrmAutoCar\Entities\ProformatPrice;
use Modules\CrmAutoCar\Models\Invoice;
use Modules\CrmAutoCar\Models\Proformat;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('crmautocar::invoices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Request $request, Invoice $invoice)
    {

        $brand = app(BrandsRepositoryContract::class)->getDefault();
        $price = (new InvoicePrice($invoice, $brand));

        return view('crmautocar::invoices.show', compact('invoice', 'price', 'brand'));
    }

    public function pdf(Invoice $invoice){

        $pdfService = app(PdfContract::class);
        $pdfService->setUrl((new SigneRoute())->signer('invoices.show', [$invoice->id]));
        $pdfService->setParamsBrowser([
            'windowSize'      => [1920, 1000],
            'enableImages'    => true,
        ]);
        $filename = $invoice->number . '-' . Str::slug($invoice->devis->dossier->client->format_name)  . '.pdf';

        return $pdfService->downloadPdf($filename);

    }
}
