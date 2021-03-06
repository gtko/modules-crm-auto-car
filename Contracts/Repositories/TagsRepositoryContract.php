<?php

namespace Modules\CrmAutoCar\Contracts\Repositories;

use Illuminate\Support\Collection;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Models\Tag;
use Modules\CrmAutoCar\Models\Template;

interface TagsRepositoryContract
{
    public function create(string $label, string $color): Tag;
    public function update(Tag $tag, string $label, string $color): Tag;
    public function remove(Tag $tag): bool;
    public function attachDossier(Dossier $dossier, Tag $tag): Tag;
    public function getByDossier(Dossier $dossier): Collection;
    public function detachTag(Dossier $dossier, Tag $tag):Tag ;
}
