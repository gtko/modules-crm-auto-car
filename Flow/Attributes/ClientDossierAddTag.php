<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\BaseCore\Repositories\UserRepository;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\CommercialRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Commercial;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\User;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;
use Modules\CrmAutoCar\Models\Tag;
use Modules\CrmAutoCar\Repositories\TagsRepository;

class ClientDossierAddTag extends Attributes
{
    public Dossier $dossier;
    public Tag $tag;
    public UserEntity $user;

    public function __construct(Dossier $dossier, Tag $tag, UserEntity $user)
    {
        parent::__construct();

        $this->dossier = $dossier;
        $this->tag = $tag;
        $this->user = $user;
    }

    public static function instance(array $value): FlowAttributes
    {
        $dossier = app(DossierRepositoryContract::class)->fetchById($value['dossier_id']);
        $tag = app(TagsRepositoryContract::class)->fetchById($value['tag_id']);
        $user = app(UserRepositoryContract::class)->fetchById($value['user_id']);

        return (new ClientDossierAddTag($dossier, $tag, $user));
    }

    public function toArray(): array
    {
        return [
            'dossier_id' => $this->dossier->id,
            'tag_id' => $this->tag->id,
            'user_id' => $this->user->id,
        ];
    }

    /**
     * @return \Modules\CoreCRM\Models\Dossier
     */
    public function getDossier(): Dossier
    {
        return $this->dossier;
    }

    /**
     * @return \Modules\CrmAutoCar\Models\Tag
     */
    public function getTag(): Tag
    {
        return $this->tag;
    }

    /**
     * @return \Modules\BaseCore\Contracts\Entities\UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }
}
