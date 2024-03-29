<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Modules\BaseCore\Actions\Personne\CreatePersonne;
use Modules\BaseCore\Contracts\Personnes\UpdatePersonneContract;
use Modules\BaseCore\Http\Requests\PersonneStoreRequest;
use Modules\BaseCore\Http\Requests\PersonneUpdateRequest;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\TagFournisseurRepositoryContract;
use Modules\CoreCRM\Http\Controllers\Controller;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Http\Requests\fournisseurUpdateRequest;


class FournisseurController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(FournisseurRepositoryContract $fournisseurRep): View|Factory|Application
    {
        $this->authorize('viewAny', Fournisseur::class);

        return view('crmautocar::app.fournisseurs.index', [
            'title' => 'Fournisseurs',
            'fournisseurs' => $fournisseurRep->disabled()->all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Fournisseur::class);
        $tagRep = app(TagFournisseurRepositoryContract::class);
        $tags = $tagRep->all();
        return view('crmautocar::app.fournisseurs.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Redirector|RedirectResponse
     * @throws AuthorizationException
     */
    public function store(fournisseurUpdateRequest $request): Redirector|RedirectResponse
    {
        $this->authorize('create', Fournisseur::class);

        $personne = (new CreatePersonne())->create($request);
        $fournisseurRep = app(FournisseurRepositoryContract::class);
        $fournisseur = $fournisseurRep->create($personne);
        $tagRep = app(TagFournisseurRepositoryContract::class);
        foreach(($request->tag_ids ?? []) as $name){
            $tag = $tagRep->newQuery()->where('name', $name)->first();
            if(!$tag){
                $tag = $tagRep->create($name);
            }
            $fournisseur->tagfournisseurs()->attach($tag);
        }

        $data = $fournisseur->data;
        $data['company'] = $request->company ?? '';
        $data['astreinte'] = $request->astreinte ?? '';
        $fournisseur->data = $data;
        $fournisseur->enabled = $request->enabled ?? false;
        $fournisseur->save();


        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur créé avec succès');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(Fournisseur $fournisseur)
    {
        $this->authorize('update', $fournisseur);
        $tagRep = app(TagFournisseurRepositoryContract::class);
        $tags = $tagRep->all();
        return view('crmautocar::app.fournisseurs.edit', compact('fournisseur', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PersonneUpdateRequest $request
     * @param UpdatePersonneContract $updatePersonne
     * @param $id
     * @return Redirector|RedirectResponse
     */
    public function update(fournisseurUpdateRequest $request, UpdatePersonneContract $updatePersonne,Fournisseur $fournisseur): Redirector|RedirectResponse
    {
        $this->authorize('update', $fournisseur);

        $updatePersonne->update($request, $fournisseur->personne);
        //on check les tags si il exist
        $fournisseur->tagfournisseurs()->detach();

        $data = $fournisseur->data;
        $data['company'] = $request->company ?? '';
        $data['astreinte'] = $request->astreinte ?? '';
        $fournisseur->data = $data;
        $fournisseur->enabled = $request->enabled ?? false;
        $fournisseur->save();

        $tagRep = app(TagFournisseurRepositoryContract::class);
        foreach(($request->tag_ids ?? []) as $name){
            $tag = $tagRep->newQuery()->where('name', $name)->first();
            if(!$tag){
                $tag = $tagRep->create($name);
            }
            $fournisseur->tagfournisseurs()->attach($tag);
        }

        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur mis à jour');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return Redirector|RedirectResponse
     */
    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();

        return '';
    }
}
