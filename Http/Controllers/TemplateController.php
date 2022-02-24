<?php

namespace Modules\CrmAutoCar\Http\Controllers;


use Illuminate\Http\Request;
use Modules\CoreCRM\Http\Controllers\Controller;
use Modules\CrmAutoCar\Contracts\Repositories\TemplatesRepositoryContract;
use Modules\CrmAutoCar\Flow\Works\Events\EventSendEmailDossier;
use Modules\CrmAutoCar\Models\Template;

class TemplateController extends Controller
{
    public function index()
    {
        $this->authorize('views-any', Template::class);

        return view('crmautocar::templates.index');
    }

    public function create()
    {
        $this->authorize('create', Template::class);

        $workflowEvent = new EventSendEmailDossier();
        $variableData = $workflowEvent->getVariablesAutoComplete();


        return view('crmautocar::templates.create',compact('variableData'));
    }

    public function store(TemplatesRepositoryContract $repTemplate, Request $request)
    {
        $this->authorize('create', Template::class);

        $repTemplate->create($request['content'], $request['title'], $request['subject']);

        return redirect()
            ->route('templates.index')
            ->withSuccess(__('basecore::crud.common.created'));
    }


    public function edit(Template $template)
    {
        $this->authorize('update', $template);

        $workflowEvent = new EventSendEmailDossier();
        $variableData = $workflowEvent->getVariablesAutoComplete();

        return view('crmautocar::templates.edit', compact('template', 'variableData'));
    }

    public function update(TemplatesRepositoryContract $repTemplate, Request $request, Template $template)
    {
        $this->authorize('update', $template);

        $repTemplate->edit($template,$request['content'],$request['title'], $request['subject']);

        return redirect()
            ->route('templates.index')
            ->withSuccess('Template mis à jour avec succés');
    }

    public function destroy($id)
    {
        dd('ok');
    }
}
