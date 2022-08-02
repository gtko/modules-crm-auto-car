<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

//        if($signature !== $request->get('sign')){
//            return response()->json(['error' => 'Signature invalide'], 403);
//        }

        $dossierRep = app(DossierRepositoryContract::class);

        //si le client a déja un dossier par l'email ou le phone et
        // qu'il a était signé on le raccroche au commercial du derniere dossier
        $dossierExistant = $dossierRep->getByEmail($request->email ?? '');
        $dossierExistant = $dossierExistant->merge($dossierRep->getByPhone($request->tel ?? ''));

        if(($request->commercial_email ?? false)){
            $commercial = Commercial::whereHas('personne', function($query) use ($request){
                $query->whereHas('emails', function($query) use ($request){
                    $query->where('email', '=', $request->commercial_email);
                });
            })->first();


            if(!$commercial){
                return response()->json(['error' => 'Commercial introuvable'], 403);
            }

        }else {
            $commercial = Commercial::where('id', 1)->first();
        }


        foreach ($dossierExistant as $item) {
            if($item->status->type === StatusTypeEnum::TYPE_WIN){
                $commercial = Commercial::where('id', $item->commercial->id)->first();
                break;
            }
        }

        $source = Source::where('label', '=', $request->source ?? '')->first();
        $status = Status::where('type', '=', StatusTypeEnum::TYPE_NEW)->first();

        /*
         * Request $request,
         * Commercial $commercial,
         * Source $source,
         * Status $status
         */

        $gender = 'other';
        if($request->get('gender', 'other') === 'Femme') {
            $gender = 'female';
        }

        if($request->get('gender', 'other') === 'Homme') {
            $gender = 'male';
        }


        $formatRequest = new Request();
        $formatRequest->replace([
            'firstname' => $request->prenom,
            'lastname' => $request->nom,
            'gender' => $gender,
            'address' => $request->adresse,
            'city' => $request->ville,
            'code_zip' => $request->code_postal,
            'country_id' => $request->pays,
            'email' => [$request->email],
            'phone' => [$request->tel],
            'date_depart' => $request->date_dep,
            'lieu_depart' => $request->depart,
            'date_arrivee' => $request->date_ret,
            'lieu_arrivee' => $request->arrivee,
            'pax_dep' => $request->pax_dep,
            'pax_ret' => $request->pax_ret,
            'type_trajet' => $request->type_trajet,
        ] + $request->all());

        Log::channel('endpoint')->info('New Lead => ' . print_r($formatRequest->toArray(), true));

        $dossier = (new CreateClient())->create($formatRequest, $commercial, $source, $status);
        $dossier->data = $formatRequest->all();
        $dossier->save();

        $dossier->client->company = $request->company;
        $dossier->client->save();


        return response()->json(['message' => 'Lead created', 'datas' => [
            'dossier_id' => $dossier->id,
            'client_id' => $dossier->client->id,
            'commercial_id' => $dossier->commercial->id,
        ]], 201);
    }
}
