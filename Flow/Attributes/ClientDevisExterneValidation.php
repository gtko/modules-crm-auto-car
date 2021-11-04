<?php


namespace Modules\CrmAutoCar\Flow\Attributes;


use Modules\BaseCore\Contracts\Entities\UserEntity;
use Modules\CoreCRM\Contracts\Entities\DevisEntities;
use Modules\CoreCRM\Contracts\Repositories\DevisRepositoryContract;
use Modules\CoreCRM\Contracts\Repositories\FournisseurRepositoryContract;
use Modules\CoreCRM\Flow\Attributes\Attributes;
use Modules\CoreCRM\Flow\Interfaces\FlowAttributes;
use Modules\CoreCRM\Models\Fournisseur;
use Modules\CrmAutoCar\Contracts\Repositories\DecaissementRepositoryContract;
use Modules\CrmAutoCar\Models\Decaissement;

class ClientDevisExterneValidation extends Attributes
{

    protected DevisEntities $devis;
    protected string $ip;

    public function __construct(DevisEntities $devis, string $ip, array $data)
    {
        parent::__construct();

        $this->devis = $devis;
        $this->ip = $ip;
        $this->data = $data;
    }

    public static function instance(array $value): FlowAttributes
    {
        $devis = app(DevisRepositoryContract::class)->fetchById($value['devis_id']);
        $data = $devis->data;
        return new ClientDevisExterneValidation($devis, $value['ip'], $data);
    }

    public function toArray(): array
    {
        return [
            'devis_id' => $this->devis->id,
            'ip' => $this->ip,
            'data' => $this->devis->data
        ];
    }

    /**
     * @return DevisEntities
     */
    public function getDevis(): DevisEntities
    {
        return $this->devis;
    }

    /**
     * @return string
     */
    public function getIp(): string
    {
        return $this->ip;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }


}
