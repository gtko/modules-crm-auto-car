<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\User;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Proformat;

class SendProformat extends Attributes
{

    public Proformat $proformat;
    public UserEntity $sender;

    public function __construct(Proformat $proformat, User $sender)
    {
        parent::__construct();

        $this->proformat = $proformat;
        $this->sender = $sender;
    }

    public function getType(): string
    {
        return static::TYPE_EMAIL;
    }

    public static function instance(array $value): FlowAttributes
    {

        $proformat = app(ProformatsRepositoryContract::class)->fetchById($value['proformat_id']);
        $sender = app(UserRepositoryContract::class)->fetchById($value['user_id']);

        return new SendProformat($proformat, $sender);
    }

    public function toArray(): array
    {
        return [
            'proformat_id' => $this->proformat->id,
            'user_id' => $this->sender->id,
        ];
    }


    public function getProformat(): Proformat
    {
        return $this->proformat;
    }

    public function getSender(): UserEntity
    {
        return $this->sender;
    }
}
