<?php


namespace Modules\CrmAutoCar\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CrmAutoCar\Contracts\Repositories\ProformatsRepositoryContract;
use Modules\CrmAutoCar\Models\Proformat;

class SendInformationVoyageMailClient extends Attributes
{
    protected UserEntity $user;
    protected Proformat $proforma;


    public function __construct(UserEntity $user, Proformat $proforma)
    {
        parent::__construct();
        $this->user = $user;
        $this->proforma = $proforma;

    }

    public static function instance(array $value): FlowAttributes
    {
        $repProforma = app(ProformatsRepositoryContract::class);
        $user = app(UserEntity::class)::find($value['user_id']);
        $proforma = $repProforma->fetchById($value['proforma_id']);

        return new self($user, $proforma);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id,
            'proforma_id' => $this->proforma->id,
        ];
    }

    /**
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }

    /**
     * @return Proformat
     */
    public function getProforma(): Proformat
    {
        return $this->proforma;
    }

    public function getProformat(): Proformat
    {
        return $this->getProforma();
    }
}
