<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\CoreCRM\Http\Controllers\Controller;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;
use Modules\CrmAutoCar\Http\Requests\TagsStoreRequest;
use Modules\CrmAutoCar\Http\Requests\TagUpdateRequest;
use Modules\CrmAutoCar\Models\Tag;

class TagController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(Request $request): Application|Factory|View
    {
        $this->authorize('views-any', Tag::class);

        return view('crmautocar::tags.index');
    }


    /**
     * @throws AuthorizationException
     */
    public function create(Request $request): View|Factory|Application
    {
        $this->authorize('create', Tag::class);

        return view('crmautocar::tags.create');
    }


    /**
     * @throws AuthorizationException
     */
    public function store(TagsStoreRequest $request, TagsRepositoryContract $tagRep): RedirectResponse
    {
        $this->authorize('create', Tag::class);

        $tag = $tagRep->create($request->label, $request->color);

        return redirect()
            ->route('tags.index')
            ->withSuccess(__('basecore::crud.common.created'));
    }


    /**
     * @throws AuthorizationException
     */
    public function show(Request $request, Tag $tag): View|Factory|Application
    {
        $this->authorize('views', $tag);

        return view('crmautocar::tags.show', compact('tag'));
    }


    /**
     * @throws AuthorizationException
     */
    public function edit(Request $request, Tag $tag): Application|Factory|View
    {
        $this->authorize('update', $tag);

        return view('crmautocar::tags.edit', compact('tag'));
    }

    /**
     * @throws AuthorizationException
     */
    public function update(TagUpdateRequest $request, TagsRepositoryContract $tagRep, Tag $tag): RedirectResponse
    {
        $this->authorize('update', $tag);

        $tagRep->update($tag, $request->label, $request->color);

        return redirect()
            ->route('tags.edit', $tag)
            ->withSuccess(__('basecore::crud.common.saved'));
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Request $request, Tag $tag): RedirectResponse
    {
        $this->authorize('delete', $tag);

        $tag->delete();

        return redirect()
            ->route('tags.index')
            ->withSuccess(__('basecore::crud.common.removed'));
    }
}
