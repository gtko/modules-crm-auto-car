<?php

namespace Modules\CrmAutoCar\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreCRM\Models\Status;

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
    }
}
