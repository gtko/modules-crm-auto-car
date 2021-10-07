<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CrmAutoCar\Contracts\Repositories\TemplatesRepositoryContract;
use Modules\CrmAutoCar\Models\Template;


class TemplateRepository extends AbstractRepository implements TemplatesRepositoryContract
{

    /**
     * @inheritDoc
     */
    public function create(string $content, string $title): Template
    {
        $template = new Template();
        $template->content = $content;
        $template->title = $title;
        $template->save();

        return $template;
    }

    public function edit(Template $template, string $content, string $title): Template
    {
       $template->content = $content;
       $template->title = $title;
       $template->save();

       return $template;
    }

    /**
     * @param Template $template
     * @return bool
     */
    public function delete(Template $template): bool
    {
        return $template->delete();
    }


    public function getModel(): Model
    {
        return new Template();
    }




    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        // TODO: Implement searchQuery() method.
    }

    public function getAll(): Collection
    {
       return Template::all();
    }
}
