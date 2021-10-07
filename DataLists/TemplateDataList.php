<?php


namespace Modules\CrmAutoCar\DataLists;

use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CrmAutoCar\Contracts\Repositories\TemplatesRepositoryContract;
use Modules\CrmAutoCar\Models\Template;
use Modules\DataListCRM\Abstracts\DataListType;

class TemplateDataList extends DataListType
{
    public function getFields():array
    {
        return [
            'title' => [
                'label' => 'Nom',
                'action' => [

                ]
            ],

            'created_at' => [
                'label' => 'Créer le',
                'format' => function($item){
                    return $item->created_at->format('d/m/Y');
                }
            ]
        ];
    }

    public function getActions(): array
    {
       return [
//           'destroy' => [
//               'permission' => ['view', Template::class],
//               'route' => function($params){
//                   return route('templates.destroy', $params);
//               },
//               'label' => 'Delete',
//               'icon' => 'delete'
//           ],
           'edit' => [
               'permission' => ['update', Template::class],
               'route' => function($params){
                   return route('templates.edit', $params);
               },
               'label' => 'edit',
               'icon' => 'edit'
           ],
       ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', Template::class],
            'route' => function(){
                return route('templates.create');
            },
            'label' => 'Ajouter un template',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []):RepositoryFetchable
    {
        return app(TemplatesRepositoryContract::class);
    }
}
