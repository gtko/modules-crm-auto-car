<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Http\Request;
use Modules\BaseCore\Actions\Url\SignePayloadUrl;
use Modules\BaseCore\Contracts\Personnes\CreatePersonneContract;
use Modules\BaseCore\Http\Requests\PersonneStoreRequest;
use Modules\CoreCRM\Actions\Clients\CreateClient;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;
use Modules\CrmAutoCar\Http\Requests\EndpointRequest;

class EndpointController
{
    public function create(EndpointRequest $request)
    {

        $signature = (new SignePayloadUrl())->generateSign(route('api.dossier.create'), $request->except('sign'));

        if($signature !== $request->get('sign')){
            return response()->json(['error' => 'Signature invalide'], 403);
        }


        $dossierRep = app(DossierRepositoryContract::class);

        //si le client a déja un dossier par l'email ou le phone et
        // qu'il a était signé on le raccroche au commercial du derniere dossier
        $dossierExistant = $dossierRep->getByEmail($request->email ?? '');
        $dossierExistant = $dossierExistant->merge($dossierRep->getByPhone($request->tel ?? ''));

        $commercial = Commercial::where('id', 1)->first();
        foreach ($dossierExistant as $item) {
            if($item->status->type === StatusTypeEnum::TYPE_WIN){
                $commercial = Commercial::where('id', $item->commercial->id)->first();
                break;
            }
        }

        $source = Source::where('label', '=', $request->source ?? '')->first();
        $status = Status::where('type', '=', StatusTypeEnum::TYPE_CUSTOM)->first();

        /*
         * Request $request,
         * Commercial $commercial,
         * Source $source,
         * Status $status
         */

        $request->firstname = $request->prenom;
        $request->lastname = $request->nom;
        $request->gender = $request->sexe ?? 'other';
        $request->address = $request->adresse;
        $request->city = $request->ville;
        $request->code_zip = $request->code_postal;
        $request->country_id = $request->pays;

        $request->email = [$request->email];
        $request->phone = [$request->tel];
        $dossier = (new CreateClient())->create($request, $commercial, $source, $status);
        $dossier->data = $request->all();
        $dossier->save();


        return response()->json(['message' => 'Lead created'], 201);
    }
}
