<?php

namespace Modules\CrmAutoCar\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Status;
use Modules\CrmAutoCar\Models\Brand;

class CrmAutoCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $statusRep = app(StatusRepositoryContract::class);
        $datas = [
            ['Prise de contact' , '#47624F'],
            ['En attente du client' , "#52AD9C"],
            ['Demande fournisseur' , '#9FFCDF'],
            ['En attente du paiement' , "#6CC551"],
        ];

        $pipeline = Pipeline::where('is_default', 1)->first();
        foreach($datas as $order => $status){
            $statusRep->create($pipeline, $status[0], $status[1], $order, StatusTypeEnum::TYPE_CUSTOM);
        }

//        foreach ($datas as $status) {
//            Status::create(['label' => $status[0], 'color' => $status[1]]);
//        }

        foreach(['Mon autocar', 'Location de car', 'Centrale autocar'] as $brand) {
            Brand::create(['label' => $brand]);
        }


    }
}
