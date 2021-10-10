<?php

namespace Modules\CrmAutoCar\Http\Controllers;

use Illuminate\Http\Request;
use Modules\CoreCRM\Http\Controllers\Controller;
use Modules\CrmAutoCar\Http\Requests\BrandStoreRequest;
use Modules\CrmAutoCar\Http\Requests\BrandUpdateRequest;
use Modules\CrmAutoCar\Models\Brand;

class BrandController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Brand::class);

        $search = '';
        $brands = Brand::latest()
            ->paginate(5);

        return view('crmautocar::brands.index', compact('brands', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        $this->authorize('create', Brand::class);

        return view('crmautocar::brands.create');
    }

    /**
     * @param \Modules\CrmAutoCar\Http\Requests\BrandStoreRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(BrandStoreRequest $request)
    {
        $this->authorize('create', Brand::class);

        $validated = $request->validated();

        $brand = Brand::create($validated);

        return redirect()
            ->route('brands.edit', $brand)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CrmAutoCar\Models\Brand $brand
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Request $request, Brand $brand)
    {
        $this->authorize('view', $brand);

        return view('crmautocar::brands.show', compact('brand'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CrmAutoCar\Models\Brand $brand
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, Brand $brand)
    {
        $this->authorize('update', $brand);

        return view('crmautocar::brands.edit', compact('brand'));
    }

    /**
     * @param \Modules\CrmAutoCar\Http\Requests\BrandUpdateRequest $request
     * @param \Modules\CrmAutoCar\Models\Brand $brand
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(BrandUpdateRequest $request, Brand $brand)
    {
        $this->authorize('update', $brand);

        $validated = $request->validated();

        $brand->update($validated);

        return redirect()
            ->route('brands.edit', $brand)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Modules\CrmAutoCar\Models\Brand $brand
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request, Brand $brand)
    {
        $this->authorize('delete', $brand);

        $brand->delete();

        return redirect()
            ->route('brands.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
