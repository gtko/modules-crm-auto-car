<?php

namespace Modules\CrmAutoCar\Flow\Attributes;

use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\BaseCore\Contracts\Repositories\UserRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\DossierRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Dossier;
use Modules\CoreCRM\Models\User;

class SendEmailDossier extends Attributes
{
    public Dossier $dossier;
    public UserEntity $sender;
    public array $email;

    public function __construct(Dossier $dossier, User $sender, $email)
    {
        parent::__construct();


        $this->dossier = $dossier;
        $this->sender = $sender;
        $this->email = $email;
    }

    public static function instance(array $value): FlowAttributes
    {

        $dossier = app(DossierRepositoryContract::class)->fetchById($value['dossier_id']);
        $sender = app(UserRepositoryContract::class)->fetchById($value['user_id']);
        $email = $value['email'];

        return new SendEmailDossier($dossier, $sender, $email);
    }

    public function toArray(): array
    {
        return [
            'dossier_id' => $this->dossier->id,
            'user_id' => $this->sender->id,
            'email' => $this->email,
        ];
    }


    /**
     * @return \Modules\CoreCRM\Models\Dossier
     */
    public function getDossier(): Dossier
    {
        return $this->dossier;
    }

    public function getSender(): UserEntity
    {
        return $this->sender;
    }

    public function getEmail(): array
    {
        return $this->email;
    }


}
