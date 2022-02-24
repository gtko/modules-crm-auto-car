<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;


use Illuminate\Database\Eloquent\Collection;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CrmAutoCar\Models\Template;


interface TemplatesRepositoryContract extends RepositoryFetchable

{
    /**
     * @return Template
     */

    public function create(string $content, string $title, string $subject): Template;
    public function edit(Template $template, string $content, string $title, string $subject): Template;
    public function delete(Template $template): bool;
    public function getAll(): Collection;

}
