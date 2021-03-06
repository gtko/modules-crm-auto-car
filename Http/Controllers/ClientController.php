<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\BaseCore\Contracts\Personnes\CreatePersonneContract;
use Modules\BaseCore\Contracts\Personnes\UpdatePersonneContract;
use Modules\CoreCRM\Actions\Clients\CreateClient;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\PipelineRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\SourceRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Http\Controllers\Controller;
use Modules\CoreCRM\Models\Client;
use Modules\BaseCore\Models\Personne;
use Modules\CoreCRM\Repositories\PipelineRepository;
use Modules\CrmAutoCar\Http\Requests\ClientStoreRequest;
use Modules\CrmAutoCar\Http\Requests\ClientUpdateRequest;

class ClientController extends Controller
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request): Application|Factory|View
    {
        $this->authorize('viewAny',ClientEntity::class);

        return view('crmautocar::app.clients.index');
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ClientEntity::class);
        $personnes = Personne::pluck('firstname', 'id');

        return view('crmautocar::app.clients.create', compact('personnes'));
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function store(ClientStoreRequest $request)
    {
        $this->authorize('create', ClientEntity::class);


        DB::beginTransaction();


        $commercial = app(CommercialRepositoryContract::class)->getById(1);
        $source = app(SourceRepositoryContract::class)->all()->first();
        $pipelineRep = app(PipelineRepositoryContract::class);
        $pipeline = $pipelineRep->getDefault();
        $status = $pipelineRep->getStatusNew($pipeline);

        $dossier = (new CreateClient())->create($request, $commercial, $source,$status);

        $dossier->client->company = $request->company;
        $dossier->client->save();

        DB::commit();
        return redirect()
            ->route('dossiers.edit', [$dossier])
            ->withSuccess(__('basecore::crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Models\ClientEntity $client
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ClientEntity $client, DossierRepositoryContract $repDossier)
    {
        $this->authorize('view', $client);

        $dossiers = $repDossier->getDossiersByClient($client);

        return view('crmautocar::app.clients.show', compact('client', 'dossiers'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, ClientEntity $client)
    {
        $this->authorize('update', $client);

        $personnes = Personne::pluck('firstname', 'id');

        return view('crmautocar::app.clients.edit', compact('client', 'personnes'));
    }

    /**
     * @param \Modules\CoreCRM\Http\Requests\ClientUpdateRequest $request
     * @param \Modules\BaseCore\Contracts\Personnes\UpdatePersonneContract $updatePersonne
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ClientUpdateRequest $request, UpdatePersonneContract $updatePersonne,ClientEntity $client)
    {
        $this->authorize('update', $client);

        DB::beginTransaction();

        $updatePersonne->update($request, $client->personne);

        $client->company = $request->company;
        $client->save();

        DB::commit();

        return redirect()
            ->route('clients.show', $client)
            ->withSuccess(__('basecore::crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CoreCRM\Contracts\Entities\ClientEntity $client
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, ClientEntity $client)
    {
        $this->authorize('delete', $client);

        $client->delete();

        return redirect()
            ->route('clients.index')
            ->withSuccess(__('basecore::crud.common.removed'));
    }
}
