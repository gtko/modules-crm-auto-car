<?php

namespace Modules\CrmAutoCar\Database\Seeders;

use Illuminate\Database\Seeder;
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
        $datas = [
            ['en attente', 'blue'],
            ['en cours' , 'orange'],
            ['cloturer' , 'gray'],
            ['terminer' , 'green']
        ];

        foreach ($datas as $status) {
            Status::create(['label' => $status[0], 'color' => $status[1]]);
        }

        foreach(['Mon autocar', 'Location de car', 'Centrale autocar'] as $brand) {
            Brand::create(['label' => $brand]);
        }

    }
}
