<?php


namespace Modules\CrmAutoCar\DataLists;


use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CrmAutoCar\Contracts\Repositories\TagsRepositoryContract;
use Modules\CrmAutoCar\Models\Tag;
use Modules\DataListCRM\Abstracts\DataListType;

class TagDataList extends DataListType
{

    public function getFields(): array
    {
        return [
            'label' => [
                'label' => 'Tag',
                'component' => [
                    'name' => 'crmautocar::components.tag',
                    'attribute' => function($item){
                        return [
                            'label' => $item->label,
                            'color' => $item->color
                        ];
                    }
                ],
                'class' => 'w-48'
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
            'show' => [
                'permission' => ['show', Tag::class],
                'route' => function($params){
                    return route('tags.show', $params);
                },
                'label' => 'voir',
                'icon' => 'show'
            ],
            'edit' => [
                'permission' => ['update', Tag::class],
                'route' => function($params){
                    return route('tags.edit', $params);
                },
                'label' => 'edit',
                'icon' => 'edit'
            ],
        ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', Tag::class],
            'route' => function(){
                return route('tags.create');
            },
            'label' => 'Ajouter un tag',
            'icon' => 'addCircle'
        ];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
        return app(TagsRepositoryContract::class);
    }
}
