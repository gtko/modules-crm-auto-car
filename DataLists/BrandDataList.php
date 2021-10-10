<?php


namespace Modules\CrmAutoCar\DataLists;





use Modules\BaseCore\Interfaces\RepositoryFetchable;
use Modules\CrmAutoCar\Contracts\Repositories\BrandsRepositoryContract;
use Modules\CrmAutoCar\Models\Brand;
use Modules\DataListCRM\Abstracts\DataListType;

class BrandDataList extends DataListType
{

    public function getFields(): array
    {
        return [
            'label' => [
                'label' => 'Marque',
                'class' => 'w-36'
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
                'permission' => ['show', Brand::class],
                'route' => function($params){
                    return route('brands.show', $params);
                },
                'label' => 'voir',
                'icon' => 'check-square'
            ],
            'edit' => [
                'permission' => ['update', Brand::class],
                'route' => function($params){
                    return route('brands.create', $params);
                },
                'label' => 'edit',
                'icon' => 'check-square'
            ],
        ];
    }

    public function getCreate(): array
    {
        return [
            'permission' => ['create', Brand::class],
            'route' => function(){
                return route('brands.create');
            },
            'label' => 'Ajouter une marque',
            'icon' => 'check-square'
        ];
    }

    public function getRepository(array $parents = []): RepositoryFetchable
    {
        return app(BrandsRepositoryContract::class);
    }
}
