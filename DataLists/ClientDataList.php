<?php


namespace Modules\CrmAutoCar\DataLists;


use Illuminate\Support\Facades\Auth;
use Modules\CoreCRM\Contracts\Entities\ClientEntity;
use Modules\CoreCRM\Contracts\Repositories\ClientRepositoryContract;
use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CoreCRM\Models\Client;
use Modules\DataListCRM\Abstracts\DataListType;

class ClientDataList extends \Modules\CoreCRM\DataLists\ClientDataList
{
    public function getFields():array
    {
        return [
            'avatar_url' => [
                'label' => '',
                'component' => [
                    'name' => 'basecore::components.avatar',
                    'attribute' => 'url',
                ],
            ],
            'format_name' => [
                'label' => 'Nom',
                'action' => [
                    'permission' => ['view', ClientEntity::class],
                    'route' => function($params){
                        return route('clients.show', $params);
                    },
                ]
            ],
            'company' => [
              'label' => 'Société',
            ],
            'email' => [
                'label' => 'Email'
            ],
            'phone' => [
                'label' => 'Téléphone'
            ],
            'created_at' => [
                'label' => 'Créer le',
                'format' => function($item){
                    return $item->created_at->format('d/m/Y');
                }
            ]
        ];
    }


}
