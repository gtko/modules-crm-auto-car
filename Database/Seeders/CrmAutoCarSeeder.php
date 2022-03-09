<?php

namespace Modules\CrmAutoCar\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Status;
use Modules\CoreCRM\Models\Workflow;
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
        Permission::create(['name' => 'change commercial proformats']);

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

        Permission::create(['name' => 'list dossiers résa']);
        Permission::create(['name' => 'views dossiers résa']);
        Permission::create(['name' => 'views-all dossiers résa']);
        Permission::create(['name' => 'create dossiers résa']);
        Permission::create(['name' => 'update dossiers résa']);
        Permission::create(['name' => 'delete dossiers résa']);

        $statusRep = app(StatusRepositoryContract::class);
        $datas = [
            ['En attente de contact' , '#000'],
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


        $tags = array(
            array('label' => 'En attente de traitement','color' => '#d1a62e','created_at' => '2021-11-19 00:51:44','updated_at' => '2021-12-06 15:35:23'),
            array('label' => 'A rappeler','color' => '#1a40d5','created_at' => '2021-11-25 15:50:44','updated_at' => '2021-12-06 15:35:44'),
            array('label' => 'En attente de tarif fournisseur','color' => '#91a211','created_at' => '2021-11-26 09:05:36','updated_at' => '2021-12-06 15:36:09'),
            array('label' => 'Fournisseur validé','color' => '#1cc610','created_at' => '2021-12-06 15:36:36','updated_at' => '2021-12-06 15:36:36'),
            array('label' => 'En attente Solde client','color' => '#b62525','created_at' => '2021-12-06 15:36:48','updated_at' => '2021-12-06 15:36:48'),
            array('label' => 'Devis envoyé','color' => '#1a56b7','created_at' => '2021-12-09 00:15:19','updated_at' => '2021-12-09 00:15:19'),
            array('label' => 'FAUX NUMERO','color' => '#000000','created_at' => '2022-01-24 15:44:55','updated_at' => '2022-01-24 15:44:55')
        );

        foreach($tags as $tag) {
            Tag::create($tag);
        }

        //workflow
        $workflows = array(
            array('name' => 'Step 1 - Attribution d\'un dossier a un commercial','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierAttribuer"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["1"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"\\u26a1\\ufe0f Vous avez un nouveau dossier #{dossier.ref} ","cc":"{commercial.email} ","content":"{commercial.nom-et-prenom} vous avez un nouveau dossier pour le client {client.nom-et-prenom} \\n\\n{dossier.lien|Voir le dossier} \\n","cci":""}]}]','active' => '1','created_at' => '2021-12-06 15:37:49','updated_at' => '2022-01-20 09:37:20'),
            array('name' => 'Step 2 - Si le commercial génère un devis','description' => '','events' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierDevisCreate"}]','conditions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Conditions\\\\ConditionCountDevis","field":"","condition":"==","value":"1"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["4"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["1"]}]','active' => '1','created_at' => '2021-12-07 15:50:14','updated_at' => '2022-01-20 11:43:18'),
            array('name' => 'Step  2 bis - Client rappeler','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierRappeler"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["2"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddCall","params":["24"]},{"class":"Modules\\\\TaskCalendarCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddTask","params":[{"title":"Rappeler le client {client.nom-et-prenom} ","hours":"24"}]}]','active' => '1','created_at' => '2021-12-07 16:08:56','updated_at' => '2021-12-09 00:13:25'),
            array('name' => 'Step 3 - devis envoyé','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventDevisSendClient"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["6"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Retrouvez votre devis {devi.ref} Centrale Autocar","cc":"{client.email} ","cci":"{commercial.email} ","content":"\\nBonjour {client.nom-et-prenom} \\n\\nJe vous remercie de l\'int\\u00e9r\\u00eat que vous portez \\u00e0 Centrale Autocar, votre complice pour tous vos transferts.\\n\\nRetrouvez votre devis n\\u00b0 {devi.ref}  en ligne en cliquant sur le boutton ci-joint.\\n\\n{devi.lien-public|Voir mon devis en ligne} \\n\\n  \\\\\\nVous trouverez en pi\\u00e8ce jointe le devis au format pdf et les condition g\\u00e9n\\u00e9ral de vente.\\n\\nJe reste \\u00e0 votre enti\\u00e8re disposition pour tout renseignement compl\\u00e9mentaire.\\n\\nCordialement,\\n\\n***{commercial.nom-et-prenom}***\\\\\\n{commercial.phone}\\\\\\n{commercial.email} \\n","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Votre devis mon autocar","cc":"{client.email} ","content":"Bonjour {client.nom-et-prenom} , \\n\\nRetrouvez ci joint votre devis mon autocar.\\n\\nCordialement.","files":[{"name":"Devis mon autocar","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNCcmFuZDJQZGZGaWxlcw=="}],"template":"MonAutoCar","delay_min":"5","delay_max":"10"}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"\\ud83d\\ude8c - Votre offre location de car est arriv\\u00e9","cc":"{client.email} ","content":"\\nBonjour {client.nom-et-prenom},\\n\\nVotre devis location car est arriv\\u00e9.\\\\\\nRetrouvez votre devis en pi\\u00e8ce jointe.\\n\\n","files":[{"name":"Devis location car","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNCcmFuZDFQZGZGaWxlcw=="}],"template":"LocationDeCar","delay_min":"10","delay_max":"15"}]}]','active' => '1','created_at' => '2021-12-09 00:16:18','updated_at' => '2022-01-21 10:36:53'),
            array('name' => 'Step 4 - devis validé','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisExterneValidation"}]','conditions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Conditions\\\\ConditionStatus","field":"","condition":"<=","value":"5"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["3"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["5"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Devis {devi.ref} valid\\u00e9 par le client {client.nom-et-prenom} ","cc":"{commercial.email} ","content":"Le devis {devi.ref} \\u00e0 \\u00e9t\\u00e9 valid\\u00e9 par le client {client.nom-et-prenom} \\n\\n{devi.lien-public} \\n \\n  \\\\\\n***T\\u00e9l\\u00e9charger le devis en PDF***\\n\\n{devi.lien-pdf}  ","cci":"","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Votre devis {devi.ref} a \\u00e9t\\u00e9 valid\\u00e9","cc":"{client.email}","content":"Bonjour {client.nom-et-prenom}\\n\\nJe vous remercie de l\'int\\u00e9r\\u00eat que vous portez \\u00e0 Centrale Autocar, votre complice pour tous vos transferts.\\n\\nVotre devis n\\u00b0{devi.ref} pour votre transfert en autocar a \\u00e9tait valid\\u00e9.\\n\\nVous trouverez en pi\\u00e8ce jointe le devis et la facture proformat au format pdf ainsi que les condition g\\u00e9n\\u00e9ral de vente.\\n\\nRetrouvez la version en ligne du devis valid\\u00e9\\n\\n{devi.lien-public} \\n\\n  \\\\\\nRetrouvez la version en ligne de votre facture proformat\\n\\n{proformat.lien-public} \\n\\n  \\\\\\nJe reste \\u00e0 votre enti\\u00e8re disposition pour tout renseignement compl\\u00e9mentaire.\\n\\nCordialement,\\n\\n***{commercial.nom-et-prenom}***\\\\\\n{commercial.phone} \\\\\\n{commercial.email} ","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2021-12-09 00:17:19','updated_at' => '2021-12-10 10:17:48'),
            array('name' => 'Step 5 - lien de paiement (cb) a plus de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":">","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"carte"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"email de paiement","cc":"{client.email} ","content":"Bonjour {client.email},\\n\\nRetrouvez ci-dessous le lien pour payer le devis {devi.ref}.\\n\\n{paiement.lien|Payer l\'accompte|30} \\n \\n\\n\\n","files":[{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="},{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="}]}]}]','active' => '1','created_at' => '2021-12-10 10:19:29','updated_at' => '2021-12-14 21:58:03'),
            array('name' => 'Step 5 -  lien de paiement (Virement) à plus de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":">","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"virement"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Paiement par virement","cc":"{client.email} ","content":"explication paiement par virement ici","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2021-12-14 15:25:02','updated_at' => '2021-12-14 21:57:51'),
            array('name' => 'Step 5 - lien de paiement (chéque) à plus de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":">","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"cheque"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Paiement par ch\\u00e8que","cc":"{client.email} ","content":"Ici le contenu de l\'email pour le paiement par ch\\u00e8que","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2021-12-14 15:26:14','updated_at' => '2021-12-14 21:58:30'),
            array('name' => 'Step 5 - lien de paiement (Virement) à moins de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":"<=","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"virement"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Paiement virement a moins de 45jours","cc":"{client.email} ","content":"ici le content","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2021-12-14 15:41:09','updated_at' => '2021-12-15 01:26:35'),
            array('name' => 'Step 5 - lien de paiement (chéque) à  moins de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":"<=","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"cheque"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Paiement a moins de 45j par email","content":"ici le content de l\'email","cc":"{client.email} ","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2021-12-14 15:42:44','updated_at' => '2021-12-14 22:00:18'),
            array('name' => 'Step 5 - lien de paiement (cb) a moins de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":"<=","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"carte"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Paiement par CB a moins de 45 jours","cc":"{client.email} ","content":"ici le content\\n\\n{paiement.lien|R\\u00e9gler la totalit\\u00e9} ","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2021-12-14 15:44:28','updated_at' => '2021-12-14 22:00:34'),
            array('name' => 'Step 6 - Paiement réalisé','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreatePaiementClient"}]','conditions' => '[]','actions' => '{"1":{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["6"]},"2":{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Paiement re\\u00e7u","cc":"{client.email} ","cci":"{commercial.email} ","content":"Bonjour, \\n\\nnous vous confirmons la bonne reception du paiement d\'un montant de X\\u20ac par \'type paiement\'.\\n\\n\\u00e0 bient\\u00f4t.","files":[{"name":"Information voyages PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcSW5mb3JtYXRpb25Wb3lhZ2VQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="}]}]},"3":{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["5"]}}','active' => '1','created_at' => '2021-12-14 22:12:45','updated_at' => '2021-12-14 22:16:44'),
            array('name' => 'Step 7 - Fournisseur BPA','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierFournisseurBpa"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionFournisseurBPA","field":"","condition":"==","value":"true"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["3"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["4"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["7"]}]','active' => '1','created_at' => '2021-12-15 01:14:27','updated_at' => '2022-01-20 11:39:46'),
            array('name' => 'Step 7.1 - Information voyage','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisExterneValidation"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Vos informations voyages","cc":"{client.email} ","files":[{"name":"Information voyages PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcSW5mb3JtYXRpb25Wb3lhZ2VQZGZGaWxlcw=="}],"content":"Bonjour, \\n\\nretrouver vos infomations voyages en PDF.\\nOu en ligne\\n\\nveuillez remplir vos informations voyage sur le formulaire suivant\\n\\n{information-voyage.lien-formulaire|Modifier mes informations voyage} "}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["7"]}]','active' => '1','created_at' => '2021-12-17 09:27:14','updated_at' => '2022-01-10 07:42:47'),
            array('name' => 'Step 8 - Validation des informations client','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisClientModifValidation"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Vos informations voyage sont prisent en compte","cc":"{client.email} ","cci":"","content":"Bonjour, \\n\\nVos informations ont \\u00e9taient prises en compte.\\n    ","files":[{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"Information voyages PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcSW5mb3JtYXRpb25Wb3lhZ2VQZGZGaWxlcw=="}]}]}]','active' => '1','created_at' => '2022-01-10 07:28:57','updated_at' => '2022-01-10 08:33:24'),
            array('name' => 'Step 7.2 - Envoie par le client des informations voyage','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisClientSaveValidation"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Le client {client.nom-et-prenom}  a envoy\\u00e9 ses informations voyage","cc":"{commercial.email} ","content":"Bonjour, \\n\\nle client a envoyer ces information voyage.\\n\\nVeuillez les valid\\u00e9 sur sa fiche.\\n\\n{dossier.lien|Voir la fiche du client} ","files":[{"name":"Information voyages PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcSW5mb3JtYXRpb25Wb3lhZ2VQZGZGaWxlcw=="}]}]}]','active' => '1','created_at' => '2022-01-10 08:30:10','updated_at' => '2022-01-10 08:32:43'),
            array('name' => 'Step 8.1 - Validation information voyage si client pas solde complet','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisClientModifValidation"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientSolde","field":"","condition":"!=","value":"complet"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["57"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["5"]}]','active' => '1','created_at' => '2022-01-10 08:34:10','updated_at' => '2022-01-10 08:50:15'),
            array('name' => 'Step 8.2 - validation information voyage et solde client payé','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisClientModifValidation"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientSolde","field":"","condition":"==","value":"complet"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["63"]}]','active' => '1','created_at' => '2022-01-10 08:54:08','updated_at' => '2022-01-10 08:55:14'),
            array('name' => 'Step 6.1 - paiement réalisé','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreatePaiementClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientSolde","field":"","condition":"==","value":"complet"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["5"]}]','active' => '1','created_at' => '2022-01-20 08:20:16','updated_at' => '2022-01-20 08:20:23'),
            array('name' => 'Notification si marge edité','description' => 'On envoie une notification quand on edit une marge sur les réservations.','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventEditMargeProformat"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Marge edit\\u00e9 sur {dossier.ref} du client {client.nom-et-prenom} }","cc":"{commercial.email} ","cci":"gtux.prog@gmail.com","content":"La r\\u00e9servation du dossier {dossier.ref} a \\u00e9t\\u00e9 modifier.\\n\\n{dossier.lien|Aller sur le dossier} \\n\\n"}]}]','active' => '1','created_at' => '2022-01-31 15:57:25','updated_at' => '2022-01-31 16:06:24')
        );

        foreach($workflows as $workflow){
            Workflow::create([
                'name' => $workflow['name'],
                'description' => $workflow['description'],
                'events' => json_decode($workflow['events']),
                'conditions' => json_decode($workflow['conditions']),
                'actions' => json_decode($workflow['actions']),
                'active' => $workflow['active'],
            ]);
        }

    }
}
