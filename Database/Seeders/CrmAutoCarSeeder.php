<?php

namespace Modules\CrmAutoCar\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Status;
use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Tag;

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
            ['En cours' , '#000'],
            ['En attente de paiement' , "#000"],
            ['En attente de résa' , '#000'],
            ["En attente d'information voyage" , "#000"],
            ['En attente Solde client' , "#000"],
            ['En attente du contact chauffeur' , "#000"],
            ['En attente de facture fournisseur' , "#000"],
        ];

        $pipeline = Pipeline::where('is_default', 1)->first();
        foreach($datas as $order => $status){
            $statusRep->create($pipeline, $status[0], $status[1], $order, StatusTypeEnum::TYPE_CUSTOM);
        }


        foreach(['Mon autocar', 'Location de car', 'Centrale autocar'] as $brand) {
            Brand::create(['label' => $brand]);
        }

        /*
         * En attente de traitement
         * A rappeler
         * En attente de tarif fournisseur
         * Fournisseur validé
         * En attente Solde client
         */

        foreach(["En attente de traitement", "A rappeler", "En attente de tarif fournisseur",
                 "Fournisseur validé", "En attente Solde client"] as $tag) {
            Tag::create(['label' => $tag]);
        }

    }
}
