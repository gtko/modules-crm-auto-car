<?php

namespace Modules\CrmAutoCar\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\BaseCore\Repositories\AbstractRepository;
use Modules\CoreCRM\Models\Dossier;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;
use Modules\CrmAutoCar\Models\Tag;

class TagsRepository extends AbstractRepository implements TagsRepositoryContract
{

    public function getModel(): Model
    {
        return new Tag();
    }

    public function searchQuery(Builder $query, string $value, mixed $parent = null): Builder
    {
        // TODO: Implement searchQuery() method.
    }

    public function create(string $label, string $color): Tag
    {
        $tag = new Tag();
        $tag->label = $label;
        $tag->color = $color;
        $tag->save();

        return $tag;
    }

    public function update(Tag $tag, string $label, string $color): Tag
    {
        $tag->label = $label;
        $tag->color = $color;
        $tag->save();

        return $tag;
    }

    public function remove(Tag $tag): bool
    {
       return $tag->delete();

    }

    public function attachDossier(Dossier $dossier, Tag $tag): Tag
    {
      $tag->dossiers()->attach($dossier);
      $tag->save();

      return $tag;
    }
}
