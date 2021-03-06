<?php


namespace Modules\CrmAutoCar\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;

class SendInformationVoyageMailFournisseur extends Attributes
{

    protected UserEntity $user;
    protected ?DevisEntities $devis;
    protected array $data;


    public function __construct(UserEntity $user, ?DevisEntities $devis, array $datas)
    {
        parent::__construct();
        $this->user = $user;
        $this->devis = $devis;
        $this->data = $datas;

    }

    public function getType(): string
    {
        return static::TYPE_EMAIL;
    }

    public static function instance(array $value): FlowAttributes
    {
        $repDevis = app(DevisRepositoryContract::class);

        $user = app(UserEntity::class)::find($value['user_id']);
        $devis = $repDevis ->fetchById($value['devis_id']);


        return new self($user, $devis, $value['data'] ?? []);
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user->id,
            'devis_id' => $this->devis->id ?? 0,
            'data' => $this->data,
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
     * @return DevisEntities
     */
    public function getDevis(): ?DevisEntities
    {
        return $this->devis;
    }

    public function getDatas(): array
    {
        return $this->data;
    }

}
