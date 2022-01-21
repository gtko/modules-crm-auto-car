<?php

namespace Modules\CrmAutoCar\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Status;
use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Tag;
use Spatie\Permission\Models\Permission;

class CrmAutoCarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Permission::create(['name' => 'list proformats']);
        Permission::create(['name' => 'views proformats']);
        Permission::create(['name' => 'create proformats']);
        Permission::create(['name' => 'update proformats']);
        Permission::create(['name' => 'delete proformats']);

        Permission::create(['name' => 'list invoices']);
        Permission::create(['name' => 'views invoices']);
        Permission::create(['name' => 'create invoices']);
        Permission::create(['name' => 'update invoices']);
        Permission::create(['name' => 'delete invoices']);

        Permission::create(['name' => 'list payments']);
        Permission::create(['name' => 'views payments']);
        Permission::create(['name' => 'create payments']);
        Permission::create(['name' => 'update payments']);
        Permission::create(['name' => 'delete payments']);

        Permission::create(['name' => 'list appels']);
        Permission::create(['name' => 'views appels']);
        Permission::create(['name' => 'create appels']);


        Permission::create(['name' => 'list demande fournisseur']);
        Permission::create(['name' => 'views demande fournisseur']);
        Permission::create(['name' => 'create demande fournisseur']);
        Permission::create(['name' => 'update demande fournisseur']);
        Permission::create(['name' => 'delete demande fournisseur']);

        Permission::create(['name' => 'list paiement fournisseur']);
        Permission::create(['name' => 'views paiement fournisseur']);
        Permission::create(['name' => 'create paiement fournisseur']);
        Permission::create(['name' => 'update paiement fournisseur']);
        Permission::create(['name' => 'delete paiement fournisseur']);

        Permission::create(['name' => 'list contact chauffeur']);
        Permission::create(['name' => 'views contact chauffeur']);
        Permission::create(['name' => 'create contact chauffeur']);
        Permission::create(['name' => 'update contact chauffeur']);
        Permission::create(['name' => 'delete contact chauffeur']);

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
