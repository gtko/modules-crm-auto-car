<?php

namespace Modules\CrmAutoCar\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\CoreCRM\Contracts\Repositories\StatusRepositoryContract;
use Modules\CoreCRM\Enum\StatusTypeEnum;
use Modules\CoreCRM\Models\Pipeline;
use Modules\CoreCRM\Models\Source;
use Modules\CoreCRM\Models\Status;
use Modules\CoreCRM\Models\Workflow;
use Modules\CrmAutoCar\Models\Brand;
use Modules\CrmAutoCar\Models\Tag;
use Modules\CrmAutoCar\Models\Template;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        $datas = array(
            array('id' => '4','label' => 'blanc','color' => '#797fa9','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '-100','type' => 'new'),
            array('id' => '5','label' => 'Terminer','color' => '#00b82e','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '900','type' => 'win'),
            array('id' => '6','label' => 'Clotûrer','color' => '#ff0000','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '901','type' => 'lost'),
            array('id' => '7','label' => 'En cours','color' => '#4d7eb3','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '2','type' => 'custom'),
            array('id' => '8','label' => 'En attente de paiement','color' => '#46c37c','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '3','type' => 'custom'),
            array('id' => '9','label' => 'En attente de résa','color' => '#2b9c2d','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '4','type' => 'custom'),
            array('id' => '10','label' => 'En attente d\'information voyage','color' => '#2d62b9','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '5','type' => 'custom'),
            array('id' => '11','label' => 'Voir si solde reçu','color' => '#d42571','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '6','type' => 'custom'),
            array('id' => '12','label' => 'En attente du contact chauffeur','color' => '#eb53ee','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '7','type' => 'custom'),
            array('id' => '13','label' => 'En attente de facture fournisseur','color' => '#077e34','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '9','type' => 'custom'),
            array('id' => '14','label' => 'Envoie de la feuille de route','color' => '#a90eb4','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '8','type' => 'custom'),
            array('id' => '15','label' => 'En attente de contact','color' => '#bea23c','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36','pipeline_id' => '1','order' => '1','type' => 'custom')
        );

        $pipeline = Pipeline::where('is_default', 1)->first();
        Status::where('pipeline_id', $pipeline->id)->delete();
        foreach($datas as $order => $status){
            $statusRep->create($pipeline, $status['label'], $status['color'], $status['order'], $status['type']);
        }


        foreach(['Centrale Autocar', 'Location de car', 'Louer un bus'] as $brand) {
            Brand::create(['label' => $brand]);
        }

        /* `crmautocar`.`sources` */
        $sources = array(
            array('id' => '3','label' => 'LP Adwords','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '4','label' => 'Direct','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '5','label' => 'Bascule','created_at' => '2022-03-29 15:19:51','updated_at' => '2022-03-29 15:19:51')
        );

        foreach($sources as $source) {
            Source::create($source);
        }

        /* `crmautocar`.`tags` */
        $tags = array(
            array('id' => '1','label' => 'En attente de traitement','color' => '#d1a62e','created_at' => '2021-11-19 00:51:44','updated_at' => '2021-12-06 15:35:23'),
            array('id' => '2','label' => 'A rappeler','color' => '#1a40d5','created_at' => '2021-11-25 15:50:44','updated_at' => '2021-12-06 15:35:44'),
            array('id' => '3','label' => 'En attente de tarif fournisseur','color' => '#91a211','created_at' => '2021-11-26 09:05:36','updated_at' => '2021-12-06 15:36:09'),
            array('id' => '4','label' => 'Fournisseur validé','color' => '#1cc610','created_at' => '2021-12-06 15:36:36','updated_at' => '2021-12-06 15:36:36'),
            array('id' => '5','label' => 'En attente Solde client','color' => '#b62525','created_at' => '2021-12-06 15:36:48','updated_at' => '2021-12-06 15:36:48'),
            array('id' => '6','label' => 'Devis envoyé','color' => '#1a56b7','created_at' => '2021-12-09 00:15:19','updated_at' => '2021-12-09 00:15:19'),
            array('id' => '7','label' => 'FAUX NUMERO','color' => '#ff0000','created_at' => '2022-01-24 15:44:55','updated_at' => '2022-02-09 14:45:55'),
            array('id' => '8','label' => 'Informations voyages envoyé FRS','color' => '#23c520','created_at' => '2022-02-04 12:54:03','updated_at' => '2022-02-04 12:54:03'),
            array('id' => '9','label' => 'FAIRE DEMANDE FRS','color' => '#eb0505','created_at' => '2022-03-19 19:12:10','updated_at' => '2022-03-19 19:12:10'),
            array('id' => '10','label' => 'En attente de BPA','color' => '#1f99d6','created_at' => '2022-03-22 15:46:19','updated_at' => '2022-03-22 15:46:19'),
            array('id' => '11','label' => 'Facture émise','color' => '#2cce4c','created_at' => '2022-03-23 11:05:17','updated_at' => '2022-03-23 11:05:17'),
            array('id' => '12','label' => 'Facture non généré','color' => '#d41c1c','created_at' => '2022-03-23 11:05:37','updated_at' => '2022-03-23 11:05:37'),
            array('id' => '13','label' => 'Règlement FRS','color' => '#f90b0b','created_at' => '2022-03-23 14:33:46','updated_at' => '2022-03-23 14:33:46'),
            array('id' => '14','label' => 'Fidéliser','color' => '#27bf1d','created_at' => '2022-03-23 14:52:22','updated_at' => '2022-03-23 14:52:22')
        );


        foreach($tags as $tag) {
            Tag::create($tag);
        }

        /* `crmautocar`.`workflows` */
        $workflows = array(
            array('id' => '1','name' => 'Step 1 - Attribution d\'un dossier a un commercial','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierAttribuer"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["1"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"\\u26a1\\ufe0f Vous avez un nouveau dossier #{dossier.ref} ","cc":"{commercial.email} ","content":"{commercial.nom-et-prenom} vous avez un nouveau dossier pour le client {client.nom-et-prenom} \\n\\n{dossier.lien|Voir le dossier} \\n","cci":""}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '2','name' => 'Step 2 - Si le commercial génère un devis','description' => '','events' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierDevisCreate"}]','conditions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Conditions\\\\ConditionCountDevis","field":"","condition":">","value":"0"},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Conditions\\\\ConditionStatus","field":"","condition":"<","value":"7"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["7"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["1"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-30 11:55:41'),
            array('id' => '3','name' => 'Step 2 bis - Client rappeler','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierRappeler"}]','conditions' => '[]','actions' => '{"0":{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["2"]},"1":{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddCall","params":["24"]},"3":{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["15"]}}','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-30 11:56:13'),
            array('id' => '4','name' => 'Step 3 - envoie des devis concurrents','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventDevisSendClient"}]','conditions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Conditions\\\\ConditionTag","field":"","condition":"notin","value":"6"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"vos trajets louer un bus","delay_min":"5","delay_max":"10","template":"louerunbus","driver":"louerunbus.fr","cc":"{client.email} ","from":"","content":"Bonjour {client.salutation}  {client.nom-et-prenom} , \\n\\nNous vous remercions de votre demande, et vous prions de trouver ci-joint notre\\nproposition.\\n \\nNous sommes \\u00e0 votre disposition pour adapter ce devis \\u00e0 vos attentes.\\n\\n \\nRecevez, Madame Monsieur, nos sinc\\u00e8res salutations.\\n\\nCordialement.","files":[{"name":"Devis louerunbus.fr","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNCcmFuZDJQZGZGaWxlcw=="}]}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Autocars-location : Votre offre de transfert en autocar","template":"autocars-location","driver":"autocars-location.fr","delay_min":"5","delay_max":"15","cc":"{client.email} ","content":"{client.salutation-avec-majuscule}  {client.nom-et-prenom}, \\n\\nNous avons le plaisir de vous transmettre notre devis.\\n\\nMerci de nous indiquer au plus vite la suite que vous envisagez y donner (positive ou n\\u00e9gative).\\n\\nBien cordialement \\\\\\nCordialement.\\n","files":[{"name":"Devis Autocar-location.fr","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNCcmFuZDFQZGZGaWxlcw=="}]}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["6"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddTimeline","params":[{"titre":"Envoie des devis concurrents","message":"Les devis concurrents, on \\u00e9t\\u00e9 envoy\\u00e9 au client."}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-31 18:08:59'),
            array('id' => '5','name' => 'Step 4 - devis validé','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisExterneValidation"}]','conditions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Conditions\\\\ConditionStatus","field":"","condition":"<=","value":"7"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["3"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["8"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Devis {devi.ref} valid\\u00e9 par le client {client.nom-et-prenom} ","cc":"{commercial.email} ","content":"Le devis {devi.ref} \\u00e0 \\u00e9t\\u00e9 valid\\u00e9 par le client {client.nom-et-prenom} \\n\\n{dossier.lien} } \\n \\n  \\\\\\n***T\\u00e9l\\u00e9charger le devis en PDF***\\n\\n{devi.lien-pdf}  ","cci":"","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Votre devis {devi.ref} a \\u00e9t\\u00e9 valid\\u00e9","cc":"{client.email}","content":"Bonjour {client.nom-et-prenom}\\n\\nJe vous remercie de l\'int\\u00e9r\\u00eat que vous portez \\u00e0 Centrale Autocar, votre complice pour tous vos transferts.\\n\\nVotre devis n\\u00b0{devi.ref} pour votre transfert en autocar a \\u00e9tait valid\\u00e9.\\n\\nVous trouverez en pi\\u00e8ce jointe le devis et la facture proformat au format pdf ainsi que les condition g\\u00e9n\\u00e9ral de vente.\\n\\nRetrouvez la version en ligne du devis valid\\u00e9\\n\\n{devi.lien-public|voir mon devis} \\n\\n  \\\\\\nRetrouvez la version en ligne de votre facture proforma\\n\\n{proformat.lien-public|voir ma proforma} \\n\\n  \\\\\\nJe reste \\u00e0 votre enti\\u00e8re disposition pour tout renseignement compl\\u00e9mentaire.\\n\\nCordialement,\\n\\nEmilie Garcin \\\\\\nResponsable Service apr\\u00e8s vente \\\\\\n@:\\u00a0contact@centrale-autocar.com \\\\\\nwww.centrale-autocar.com \\\\\\n57 Rue Clisson- 75013 Paris \\\\\\nTel : 01 87 21 14 76 \\\\\\nNum\\u00e9ro\\u00a0d\'urgence : 06 18 37 37 70\\n\\n","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="},{"name":"RIB","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUklCUGRmRmlsZXM="}]}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["9"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddNotif","params":[{"email":"{commercial.email}, adrien.v@centrale-autocar.com","url":"{dossier.lien} ","image":"{client.avatar} ","title":"Nouvelle r\\u00e9servation {dossier.ref} ","content":"Vous avez une nouvelle r\\u00e9servation {dossier.ref} "}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-04-04 12:25:20'),
            array('id' => '6','name' => 'Step 5 - lien de paiement (cb) a plus de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":">","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"carte"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"email de paiement","cc":"{client.email} ","content":"Bonjour {client.email},\\n\\nRetrouvez ci-dessous le lien pour payer le devis {devi.ref}.\\n\\n{paiement.lien|Payer l\'accompte|30} \\n \\n\\n\\n","files":[{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="},{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="}]}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-31 18:04:36'),
            array('id' => '7','name' => 'Step 5 -  lien de paiement (Virement) à plus de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":">","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"virement"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Votre r\\u00e9servation d\'autocar virement plus de 45 jours","cc":"{client.email} ","content":"Bonjour {client.nom-et-prenom}, \\n\\nNous vous remercions d\'avoir proc\\u00e9d\\u00e9 \\u00e0 la validation de nos conditions g\\u00e9n\\u00e9rales de ventes et proc\\u00e9dons \\u00e0 la confirmation de votre commande.\\n\\nNous vous rappelons que la r\\u00e9servation sera totalement d\\u00e9finitive  apr\\u00e8s r\\u00e9ception de l\'acompte de 30%.\\n* Toute r\\u00e9servation effectu\\u00e9e \\u00e0 moins de 45 jours du  d\\u00e9part, sera \\u00e9tablie \\u00e0  r\\u00e9ception du montant total de la r\\u00e9servation.\\n\\nPour rappel la validation en ligne implique une acceptation totale de nos conditions g\\u00e9n\\u00e9rales de ventes et donc des conditions d\'annulations ci dessous:\\n\\n- 30 % du prix du service si l\\u2019annulation intervient \\u00e0 plus de 30 jours avant le d\\u00e9part\\n- 50 % du prix du service si l\\u2019annulation intervient entre 30 et 14 jours avant le d\\u00e9part\\n- 70 % du prix du service si l\\u2019annulation intervient entre 13 et 7 jours avant le d\\u00e9part\\n- 100 % du prix du service si l\\u2019annulation intervient moins de 7 jours avant le d\\u00e9part.\\n\\nCi dessous notre RIB:\\n\\nIban : FR76 3000 4015 9600 0101 0820 195 \\\\\\nBIC: BNPAFRPPXXX \\\\\\nCode Banque: 30004 \\\\\\nCode Guichet: 01596 \\\\\\nNum\\u00e9ro de compte: 00010108201 \\\\\\nCl\\u00e9 RIB: 95 \\\\\\nTitulaire du compte: Centrale Autocar \\\\\\n\\nPensez \\u00e0 bien pr\\u00e9cisez votre num\\u00e9ro de dossier ou de devis dans le motif votre virement\\n\\nLe service apr\\u00e8s vente vous recontactera sous 48h, afin de vous aider dans la mise en place de votre transfert. \\n\\nDans un second email, vous recevrez les informations voyageurs a compl\\u00e9ter et nous renvoyer le plus rapidement possible a l\'adresse suivante: contact@centrale-autocar.com.\\n\\nComme toujours, notre Service Client\\u00e8le reste \\u00e0 votre disposition pour tout renseignement, avant, pendant et m\\u00eame apr\\u00e8s votre transfert.\\n\\nCentrale Autocar-Service R\\u00e9servation\\n@: contact@centrale-autocar.com\\n\\nwww.centrale-autocar.com\\nTel: 01 87 21 14 76","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '8','name' => 'Step 5 - lien de paiement (chéque) à plus de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":">","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"cheque"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Paiement par ch\\u00e8que","cc":"{client.email} ","content":"Ici le contenu de l\'email pour le paiement par ch\\u00e8que","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '9','name' => 'Step 5 - lien de paiement (Virement) à moins de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":"<=","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"virement"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Votre r\\u00e9servation d\'autocar paiement par virement","cc":"{client.email} ","content":"Bonjour {client.salutation-avec-majuscule} {client.nom-et-prenom} , \\n\\nNous vous remercions d\'avoir proc\\u00e9d\\u00e9 \\u00e0 la validation de nos conditions g\\u00e9n\\u00e9rales de ventes et proc\\u00e9dons \\u00e0 la confirmation de votre commande.\\n\\nPour rappel la validation en ligne implique une acceptation totale de nos conditions g\\u00e9n\\u00e9rales de ventes et donc des conditions d\'annulations ci dessous:\\n\\n- 30 % du prix du service si l\\u2019annulation intervient \\u00e0 plus de 30 jours avant le d\\u00e9part\\n- 50 % du prix du service si l\\u2019annulation intervient entre 30 et 14 jours avant le d\\u00e9part\\n- 70 % du prix du service si l\\u2019annulation intervient entre 13 et 7 jours avant le d\\u00e9part\\n- 100 % du prix du service si l\\u2019annulation intervient moins de 7 jours avant le d\\u00e9part\\n\\nMerci de bien vouloir nous faire parvenir votre justificatif de virement pour validation d\\u00e9finitive de votre r\\u00e9servation au plus tard 48h ouvr\\u00e9s apr\\u00e8s votre r\\u00e9servation.\\n\\nVotre transfert ayant lieu dans moins de 45 jours, nous vous rappelons que le contact chauffeur sera envoy\\u00e9  uniquement apr\\u00e8s r\\u00e9ception du r\\u00e8glement total de votre transfert.\\n\\nCi dessous notre RIB:\\n\\nIban : FR76 3000 4015 9600 0101 0820 195 \\\\\\nBIC: BNPAFRPPXXX \\\\\\nCode Banque: 30004 \\\\\\nCode Guichet: 01596 \\\\\\nNum\\u00e9ro de compte: 00010108201 \\\\\\nCl\\u00e9 RIB: 95 \\\\\\nTitulaire du compte: Centrale Autocar \\\\\\n\\nPensez \\u00e0 bien pr\\u00e9cisez votre num\\u00e9ro de dossier ou de devis dans le motif votre virement\\n\\nLe service apr\\u00e8s vente vous recontactera sous 48h , afin de vous aider dans la mise en place de votre transfert. \\n\\nDans un second email, vous recevrez les informations voyageurs a compl\\u00e9ter et nous renvoyer le plus rapidement possible a l\'adresse suivante: contact@centrale-autocar.com.\\n\\nComme toujours, notre Service Client\\u00e8le reste \\u00e0 votre disposition pour tout renseignement, avant, pendant et m\\u00eame apr\\u00e8s votre transfert.\\n\\nCentrale Autocar-Service R\\u00e9servation \\\\\\n@: contact@centrale-autocar.com \\\\\\nwww.centrale-autocar.com \\\\\\nTel: 01 87 21 14 76 \\\\","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '10','name' => 'Step 5 - lien de paiement (chéque) à  moins de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":"<=","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"cheque"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Paiement a moins de 45j par email","content":"ici le content de l\'email","cc":"{client.email} ","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '11','name' => 'Step 5 - lien de paiement (cb) a moins de 45 jours','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateProformatClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionDateDepartDevis","field":"","condition":"<=","value":"45"},{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientTypeValidation","field":"","condition":"==","value":"carte"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Paiement par CB a moins de 45 jours","cc":"{client.email} ","content":"ici le content\\n\\n{paiement.lien|R\\u00e9gler la totalit\\u00e9} ","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="},{"name":"CGU PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}]}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '12','name' => 'Step 6 - Paiement réalisé','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreatePaiementClient"}]','conditions' => '[]','actions' => '{"2":{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":" Paiement re\\u00e7u Centrale Autocar sur le dossier #{dossier.ref} ","cc":"{client.email} ","cci":"{commercial.email} ","content":"Bonjour {client.nom-et-prenom} , \\n\\nNous vous confirmons la bonne r\\u00e9ception du paiement d\'un montant de {paiement.paye} \\u20ac sur un total dossier de {paiement.total-ttc} \\u20ac.\\n\\nA bient\\u00f4t.\\n\\nCentrale Autocar-Service R\\u00e9servation\\n@: {commercial.email} \\nwww.centrale-autocar.com\\nTel: {commercial.phone} ","files":[{"name":"Facture Proformat PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="}]}]},"3":{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["5"]}}','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-27 15:56:11'),
            array('id' => '13','name' => 'Step 7 - Fournisseur BPA','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierFournisseurBpa"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionFournisseurBPA","field":"","condition":"==","value":"true"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["3"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["4"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["10"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["9"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["10"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["13"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-30 12:01:48'),
            array('id' => '14','name' => 'Step 7.1 - Information voyage','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisExterneValidation"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Vos informations voyages Centrale Autocar pour le dossier #{dossier.ref} ","cc":"{client.email} ","files":[],"content":"Bonjour {client.salutation} {client.nom-et-prenom}, \\n\\nAfin de bien pr\\u00e9parer votre voyage merci de bien vouloir me faire parvenir au plus vite les informations suivantes.\\n\\n\\nVeuillez trouvez en ligne vos informations voyages :\\n\\n{information-voyage.lien-formulaire|Informations voyage} \\n\\n\\nEn cas de prise en charge ou d\'arriv\\u00e9e au sein d\'un a\\u00e9roport ou d\'une gare, nous vous remercions de nous indiquer les num\\u00e9ros de vols, num\\u00e9ros de trains ainsi que les terminaux concern\\u00e9s.\\n\\n****Pour rappel, le port du masque est obligatoire dans le car, et ce pendant toute la dur\\u00e9e du trajet****\\n\\nListe personnes transport\\u00e9es : Suite \\u00e0 l\\u2019arr\\u00eat\\u00e9 du 18\\/05\\/09, et pour tout transport hors d\\u00e9partement et d\\u00e9partements limitrophes, nous vous remercions de nous fournir au d\\u00e9part du car, une liste des passagers (Nom \\u2013 Pr\\u00e9nom), sur papier \\u00e0 en-t\\u00eate ou sur papier libre, avec le nom de l\\u2019organisateur. S\\u2019\\u2019il s\\u2019agit d\\u2019enfants, ajouter le num\\u00e9ro de t\\u00e9l\\u00e9phone de leur r\\u00e9f\\u00e9rent.\\n\\nLors du chargement du groupe, votre responsable devra noter sur la feuille le num\\u00e9ro d\\u2019immatriculation et remettre le document \\u00e0 notre conducteur. Merci de votre contribution et compr\\u00e9hension, ce document \\u00e9tant obligatoire en cas de contr\\u00f4le routier.\\n\\nA bient\\u00f4t, \\n\\nCentrale Autocar - Service R\\u00e9servation \\\\\\n@: contact@centrale-autocar.com \\\\\\nwww.centrale-autocar.com \\\\\\nTel: 01 87 21 14 76 \\\\"}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-27 15:23:11'),
            array('id' => '15','name' => 'Step 8 - Validation des informations client','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisClientModifValidation"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Vos informations voyage ont \\u00e9t\\u00e9 enregistr\\u00e9es","cc":"{client.email} ","cci":"","content":"Bonjour {client.salutation} {client.nom-et-prenom} , \\n\\nVos informations voyage ont \\u00e9t\\u00e9 prise en compte.\\n\\nA bient\\u00f4t, \\n\\nCentrale Autocar - Service R\\u00e9servation \\\\\\n@: contact@centrale-autocar.com \\\\\\nwww.centrale-autocar.com \\\\\\nTel: 01 87 21 14 76 \\\\","files":[],"from":"","from_name":""}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["12"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-31 18:02:35'),
            array('id' => '16','name' => 'Step 7.2 - Envoie par le client des informations voyage','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisClientSaveValidation"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Le client {client.nom-et-prenom}  a envoy\\u00e9 ses informations voyage","cc":"{gestionnaire.email} ","content":"Bonjour, \\n\\nle client a envoyer ces information voyage.\\n\\nVeuillez les valid\\u00e9 sur sa fiche.\\n\\n{dossier.lien|Voir la fiche du client} ","files":[]}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddTimeline","params":[{"titre":"Mise a jour des informations voyage par le client","message":"le client {client.nom-et-prenom} \\u00e0 mis a jour ces informations voyage pour la proforma {proformat.numero} et le devis {devi.ref}.\\n"}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddNotif","params":[{"email":"{gestionnaire.email} ","url":"{dossier.lien} ","image":"{client.avatar} ","title":"Information voyage re\\u00e7u","content":"Vous avez re\\u00e7u les informations voyage"}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-04-04 12:28:40'),
            array('id' => '17','name' => 'Step 8.1 - Validation information voyage si client pas solde complet','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisClientModifValidation"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientSolde","field":"","condition":"!=","value":"complet"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["11"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["5"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-30 16:16:33'),
            array('id' => '18','name' => 'Step 8.2 - validation information voyage et solde client payé','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDevisClientModifValidation"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientSolde","field":"","condition":"==","value":"complet"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["12"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["5"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-30 16:16:39'),
            array('id' => '19','name' => 'Step 6.1 - paiement réalisé "Solde complet" ','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreatePaiementClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientSolde","field":"","condition":"==","value":"complet"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["5"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-27 15:43:50'),
            array('id' => '20','name' => 'Notification si marge edité','description' => 'On envoie une notification quand on edit une marge sur les réservations.','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventEditMargeProformat"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Marge edit\\u00e9 sur {dossier.ref} du client {client.nom-et-prenom} }","cc":"{commercial.email} ","cci":"gtux.prog@gmail.com","content":"La r\\u00e9servation du dossier {dossier.ref} a \\u00e9t\\u00e9 modifier.\\n\\n{dossier.lien|Aller sur le dossier} \\n\\n"}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddNotif","params":[{"email":"{commercial.email} ","url":"{dossier.lien} ","image":"{client.avatar} ","title":"Marge \\u00e9dit\\u00e9 sur le dossier {dossier.ref} ","content":"La marge vient d\'\\u00eatre \\u00e9dit\\u00e9 pour le dossier {dossier.ref} "}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-04-04 12:29:42'),
            array('id' => '21','name' => 'Step 9 : Envoie des informations voyages au fournisseur','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventSendInformationVoyageMailFournisseur"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Les informations voyages","cc":"gtux.prog@gmail.com","content":"Bonjour {fournisseur.full-name}, \\n\\nVeuillez trouvez ci joint les informations voyage pour le transport num\\u00e9ro {devis.ref} a la date {devi.date-depart} \\n\\nTrajet  : \\n{fournisseur.details} \\n\\n\\n","files":[{"name":"Information voyages PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcSW5mb3JtYXRpb25Wb3lhZ2VQZGZGaWxlcw=="}]}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["8"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '22','name' => 'Step 9.1 : Envoie de la feuille de route','description' => '','events' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierNoteCreate"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["13"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-30 16:18:18'),
            array('id' => '23','name' => 'Si faux numéro clôturer dossier','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventAddTagDossier"}]','conditions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Conditions\\\\ConditionTag","field":"","condition":"in","value":"7"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"{commercial.email}  - vous avez re\\u00e7u un email","cc":"{commercial.email} ","cci":"","content":"bonjour {client.salutation-avec-majuscule} , \\n\\nJ\'ai bien re\\u00e7u votre demande de recherche de transfert en autocar, cependant je n\'ai pas r\\u00e9ussi \\u00e0 vous joindre au num\\u00e9ro indiqu\\u00e9  \\n\\nAuriez-vous un autre num\\u00e9ro de t\\u00e9l\\u00e9phone \\u00e0 me communiquer ? A quel moment pouvons nous fixer ensemble un RDV t\\u00e9l\\u00e9phonique ?\\n\\nD\'ici l\\u00e0, je vous invite \\u00e0 me faire part de vos crit\\u00e8res par mail afin que je puisse avancer dans mes recherches\\u00a0 et vous\\u00a0\\u00a0adresser un devis dans les meilleurs d\\u00e9lais.\\n\\n\\nALLER :\\nDate de d\\u00e9part :\\nHeure de d\\u00e9part :\\nVille et code postal de d\\u00e9part :\\nVille et code postal d\'arriv\\u00e9e :\\n\\n\\nRETOUR :\\n\\nDate de d\\u00e9part :\\nHeure de d\\u00e9part :\\nVille et code postal de d\\u00e9part :\\nVille et code postal d\'arriv\\u00e9e :\\n\\nCircuit:\\u00a0\\n\\nNombre de personnes :\\n\\nObjet du d\\u00e9placement (\\u00e9tudiants, \\u00e9tablissements scolaires, \\u00e9tablissements publics, entreprises, associations, particuliers, scouts...) :\\n\\n\\nDans l\'attente de votre r\\u00e9ponse,\\n\\n{commercial.signature} \\n"}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["3"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-27 15:09:40'),
            array('id' => '24','name' => 'Envoyer la proformat manuellement','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventSendProformat"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Votre facture proformat {proformat.numero}  - Centrale autocar","cc":"{client.email} ","from":"{utilisateur.email} ","content":"Bonjour {client.salutation-avec-majuscule}  {client.nom-et-prenom} , \\n\\nSuite \\u00e0 la validation en ligne de votre devis veuillez trouver ci-joint votre proforma.\\n\\nAfin de visualiser la facture Proforma concernant votre transfert en autocar du {devi.date-depart}  , je vous prie de bien vouloir cliquer sur le lien suivant :\\n\\n{proformat.lien-pdf|Voir ma proforma} \\n\\nJe reste \\u00e0 votre enti\\u00e8re disposition pour tout renseignement compl\\u00e9mentaire.\\n\\nCordialement,\\n\\n{commercial.signature} \\n\\n\\n","files":[{"name":"Facture Proforma PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcUHJvZm9ybWF0UGRmRmlsZXM="}]}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddTimeline","params":[{"titre":"Envoie de la facture proforma","message":"{utilisateur.nom-et-prenom} a envoy\\u00e9 la facture proforma au client."}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddNotif","params":[{"email":"{gestionnaire.email} ","url":"{dossier.lien|text}","image":"{gestionnaire.avatar|text} ","title":"Facture proforma {proformat.numero}  envoy\\u00e9 au client","content":"{utilisateur.nom-et-prenom} a envoy\\u00e9 la facture proforma au client."}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-04-03 02:34:53'),
            array('id' => '25','name' => 'Step 3.1 : Envoie d\'un devis','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventDevisManualSendClient"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Votre devis pour la location d\'autocar {devi.ref} ","cc":"{client.email} ","cci":"","content":"Bonjour {client.salutation-avec-majuscule} {client.nom-et-prenom} ,\\n\\nJe vous remercie de l\'int\\u00e9r\\u00eat que vous portez \\u00e0 Centrale Autocar, votre complice pour tous vos transferts.\\n\\nVeuillez trouver le devis {devi.ref}  pour votre transfert en autocar le {devi.date-depart}   en cliquant ici :\\n{devi.lien-public|Votre devis en ligne} \\n\\n\\nJe reste \\u00e0 votre enti\\u00e8re disposition pour tout renseignement compl\\u00e9mentaire.\\n\\nCordialement,\\n{commercial.signature} ","files":[{"name":"DEVIS PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcRGV2aXNQZGZGaWxlcw=="},{"name":"CGV PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcQ2d1UGRmRmlsZXM="}],"driver":"Default","template":"default","from":"{commercial.email} ","from_name":"{commercial.nom-et-prenom}  de Centrale Autocar"}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-27 15:17:38'),
            array('id' => '26','name' => 'Envoyer demande fournisseurs','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierDemandeFournisseurSend"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Demande de prix pour la demande {devi.ref} ","cc":"{fournisseur.email} ","cci":"","content":"Bonjour {fournisseur.full-name}, \\n\\nVeuillez trouver ci-dessous une nouvelle demande:\\n\\n{fournisseur.details} \\n\\nDans l\'attente de votre meilleure offre pour ce transfert.\\n\\nMerci d\'avance \\\\\\n\\u00e0 bient\\u00f4t\\n","from":"reservation@centrale-autocar.com","from_name":"Centrale Autocar"}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddTimeline","params":[{"titre":"Demande de prix aux fournisseurs envoy\\u00e9","message":"{utilisateur.nom-et-prenom} a envoy\\u00e9 une demande de prix \\u00e0 {fournisseur.full-name} "}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '27','name' => 'Envoie manuel des informations voyages','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventSendInformationVoyageMailClient"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Les informations voyages pour votre trajet {devi.ref} ","cc":"{client.email} ","content":"Bonjour {client.salutation} {client.nom-et-prenom}, \\n\\nAfin de bien pr\\u00e9parer votre voyage merci de bien vouloir me faire parvenir au plus vite les informations suivantes.\\n\\nEn cas de prise en charge ou d\'arriv\\u00e9e au sein d\'un a\\u00e9roport ou d\'une gare, nous vous remercions de nous indiquer les num\\u00e9ros de vols, num\\u00e9ros de trains ainsi que les terminaux concern\\u00e9s.\\n\\nVeuillez trouvez en ligne vos informations voyages :\\n\\n{information-voyage.lien-formulaire|Informations voyage} \\n\\n****Pour rappel, le port du masque est obligatoire dans le car, et ce pendant toute la dur\\u00e9e du trajet****\\n\\nListe personnes transport\\u00e9es : Suite \\u00e0 l\\u2019arr\\u00eat\\u00e9 du 18\\/05\\/09, et pour tout transport hors d\\u00e9partement et d\\u00e9partements limitrophes, nous vous remercionsde nous fournir au d\\u00e9part du car, une liste des passagers (Nom \\u2013 Pr\\u00e9nom), sur papier \\u00e0 en-t\\u00eate ou sur papier libre, avec le nom de l\\u2019organisateur. S\\u2019\\u2019il s\\u2019agit d\\u2019enfants, ajouter le num\\u00e9ro de t\\u00e9l\\u00e9phone de leur r\\u00e9f\\u00e9rent.\\n\\n\\nLors du chargement du groupe, votre responsable devra noter sur la feuille le num\\u00e9ro d\\u2019immatriculation et remettre le document \\u00e0 notre conducteur. Merci de votre contribution et compr\\u00e9hension, ce document \\u00e9tant obligatoire en cas de contr\\u00f4le routier.\\n\\nA bient\\u00f4t, \\n{commercial.signature} \\n","from":"","from_name":""}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddTimeline","params":[{"titre":"Envoie des informations voyage au client","message":"<b>{utilisateur.nom-et-prenom}<\\/b> \\u00e0 envoy\\u00e9 les informations voyage au client"}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '28','name' => 'Step 8 - envoie des infos contact chauffeur / voyage au clients','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventSendContactChauffeurToClient"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Vos informations voyage pour le dossier {dossier.ref} ","cc":"{client.email} ","content":"Bonjour {client.salutation} {client.nom-et-prenom}, \\n\\nVeuillez trouver ci-joint les informations voyage et les contact chauffeur pour votre futur trajet.\\n\\n{fournisseur.details} \\n\\n\\nEn vous souhaitant une bonne reception.\\n\\nEmilie Garcin \\\\\\nResponsable Service apr\\u00e8s vente \\\\\\n@:\\u00a0contact@centrale-autocar.com \\\\\\nwww.centrale-autocar.com \\\\\\n57 Rue Clisson- 75013 Paris \\\\\\nTel : 01 87 21 14 76 \\\\\\nNum\\u00e9ro\\u00a0d\'urgence : 06 18 37 37 70 \\\\","files":[{"name":"Information voyages PDF","class":"TW9kdWxlc1xDcm1BdXRvQ2FyXEZsb3dcV29ya3NcRmlsZXNcSW5mb3JtYXRpb25Wb3lhZ2VQZGZGaWxlcw=="}]}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["13"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-30 16:18:03'),
            array('id' => '29','name' => 'Paiement timeline','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreatePaiementClient"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddTimeline","params":[{"titre":"Un r\\u00e8glement a \\u00e9t\\u00e9 enregistr\\u00e9","message":"Nouveau r\\u00e9glement pour la proforma {proformat.numero} {paiement.paye}\\u20ac et il reste {paiement.reste}\\u20ac "}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '30','name' => 'Demande fournisseur validé','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierDemandeFournisseurValidate"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["10"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["3"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '31','name' => 'Step 6.2 Paiement réalisé incomplet','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreatePaiementClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientSolde","field":"","condition":"!=","value":"complet"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["5"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-30 11:59:16'),
            array('id' => '32','name' => 'Step 10 - Génération de la facture','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreateInvoiceClient"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddTimeline","params":[{"titre":"G\\u00e9n\\u00e9ration de la facture {facture.numero} ","message":"Cr\\u00e9ation de la facture {facture.numero} d\'un montant de {facture.total}\\u20ac"}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-30 16:21:31'),
            array('id' => '33','name' => 'Step 9.3 - Réglement fournisseur check','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierPaiementFournisseurSend"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionFournisseurSolde","field":"","condition":"==","value":"complet"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["13"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '34','name' => 'Envoie de la facture','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventSendInvoice"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Retrouvez votre facture {facture.numero}  de Centrale AutoCar","cc":"{client.email} ","content":"Bonjour {client.salutation-avec-majuscule}  {client.nom-et-prenom} , \\n\\nAfin de visualiser la facture concernant votre transfert en autocar  , je vous prie de bien vouloir cliquer sur le lien suivant :\\n\\n{facture.lien-public|Voir ma facture} \\n\\n  \\\\\\nPour t\\u00e9l\\u00e9charger votre facture en pdf\\n\\n{facture.lien-pdf|T\\u00e9l\\u00e9charger ma facture} \\n\\n  \\\\\\nJe reste \\u00e0 votre enti\\u00e8re disposition pour tout renseignement compl\\u00e9mentaire.\\n\\nBien cordialement,\\n\\n{gestionnaire.signature} \\n"}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["11"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSupprimerTag","params":["12"]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-03-26 22:22:36'),
            array('id' => '35','name' => 'Step 11 - fidélisation','description' => 'A la date de retour du dossier , envoyer un email de fidélisation','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierFideliser"}]','conditions' => '[]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAjouterTag","params":["14"]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsSendNotification","params":[{"subject":"Fid\\u00e9lisation Centrale AutoCar pour le dossier {dossier.ref} ","cc":"{client.email} ","from":"{commercial.email} ","from_name":"{commercial.nom-et-prenom} de Centrale AutoCar","content":"Bonjour {client.salutation-avec-majuscule} {client.nom-et-prenom} \\n\\nVous avez r\\u00e9cemment \\u00e9t\\u00e9 accompagn\\u00e9 par notre Centrale pour votre voyage et nous esp\\u00e9rons que vous avez appr\\u00e9ci\\u00e9 votre exp\\u00e9rience avec Centrale Autocar.\\n\\nNous vous en remercions et esp\\u00e9rons vous avoir satisfait.\\n\\nVotre avis nous est pr\\u00e9cieux et nous serions ravis que vous partagiez votre exp\\u00e9rience.\\n\\nCi dessous le lien: \\n\\n<a href=\'https:\\/\\/g.page\\/r\\/CVSnfhrYw313EAg\\/review\'>Partager ici votre exp\\u00e9rience<\\/a>\\n\\nToute l\'\\u00e9quipe vous remercie et reste \\u00e0 votre disposition.\\n\\nA bient\\u00f4t,\\n\\n{commercial.signature} "}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddTimeline","params":[{"message":"Email de fid\\u00e9lisation envoy\\u00e9 au client pour le commercial {commercial.nom-et-prenom}","titre":"Fid\\u00e9lisation du dossier"}]},{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddNotif","params":[{"email":"{commercial.email} ","url":"{dossier.lien} ","image":"{client.avatar} ","title":"Fid\\u00e9lisation du client","content":"Un email de fid\\u00e9lisation a \\u00e9t\\u00e9 envoy\\u00e9 au client {client.nom-et-prenom} "}]}]','active' => '1','created_at' => '2022-03-26 22:22:36','updated_at' => '2022-04-04 12:12:25'),
            array('id' => '36','name' => 'Step 6.3 - Changement du status','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreatePaiementClient"}]','conditions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Conditions\\\\ConditionStatus","field":"","condition":"<","value":"9"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsChangeStatus","params":["9"]}]','active' => '1','created_at' => '2022-03-30 12:38:19','updated_at' => '2022-03-30 12:38:40'),
            array('id' => '37','name' => 'Clôturer dossier','description' => '','events' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Events\\\\EventClientDossierUpdate"}]','conditions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Conditions\\\\ConditionStatus","field":"","condition":"==","value":"6"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsDetachAllTag","params":[]}]','active' => '1','created_at' => '2022-04-04 10:48:29','updated_at' => '2022-04-04 10:58:44'),
            array('id' => '38','name' => 'Step 6.4 - Paiement acompte','description' => '','events' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Events\\\\EventCreatePaiementClient"}]','conditions' => '[{"class":"Modules\\\\CrmAutoCar\\\\Flow\\\\Works\\\\Conditions\\\\ConditionClientSolde","field":"","condition":"==","value":"partiel"}]','actions' => '[{"class":"Modules\\\\CoreCRM\\\\Flow\\\\Works\\\\Actions\\\\ActionsAddNotif","params":[{"email":"{commercial.email}, {gestionnaire.email}","url":"{dossier.lien} ","image":"{client.avatar} ","title":"Versement acompte re\\u00e7u {dossier.ref} ","content":"Vous avez re\\u00e7u l\'acompte du dossier {dossier.ref} "}]}]','active' => '1','created_at' => '2022-04-04 12:27:41','updated_at' => '2022-04-04 12:27:51')
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


        /* `crmautocar`.`templates` */
        $templates = array(
            array('id' => '1','title' => 'Nouvelle demande','content' => '<p>Bonjour&nbsp;{client.salutation-avec-majuscule}&nbsp;</p><p>J\'ai bien reçu votre demande de recherche de transfert en autocar, cependant je n\'ai pas réussi à vous joindre au numéro indiqué</p><p>Auriez-vous un autre numéro de téléphone à me communiquer ? A quel moment pouvons nous fixer ensemble un RDV téléphonique ?</p><p>D\'ici là, je vous invite à me faire part de vos critères par mail afin que je puisse avancer dans mes recherches&nbsp; et vous&nbsp;&nbsp;adresser un devis dans les meilleurs délais.</p><p><br />ALLER :<br />Date de départ :<br />Heure de départ :<br />Ville et code postal de départ :<br />Ville et code postal d\'arrivée :</p><p><br />RETOUR :</p><p>Date de départ :<br />Heure de départ :<br />Ville et code postal de départ :<br />Ville et code postal d\'arrivée :</p><p> </p><p>Circuit:&nbsp;</p><p><br />Nombre de personnes :</p><p><br />Objet du déplacement (étudiants, établissements scolaires, établissements publics, entreprises, associations, particuliers, scouts...) :</p><p><br />Dans l\'attente de votre réponse,<br /> </p><p><br />Bien cordialement,</p><p> </p><p>{commercial.signature}&nbsp;</p>','created_at' => '2022-02-04 12:12:58','updated_at' => '2022-03-18 11:54:38','subject' => 'Votre recherche de transport en autocar {dossier.ref}'),
            array('id' => '2','title' => 'Fidélisation','content' => '<p>Bonjour&nbsp;{client.salutation-avec-majuscule}&nbsp;</p><p>Notre service de réservation a eu le plaisir d\'effectuer votre réservation pour un transfert en autocar.</p><p>Nous tenons&nbsp; à vous remercier pour la confiance que vous nous avez accordée.&nbsp;</p><p>Nous espérons que ce premier partenariat&nbsp; a été fructueux et sommes à votre disposition pour vous assister lors d\'un futur transfert.</p><p>N\'hésitez pas à nous contacter au 01 87 21 14 76 ou bien par mail à contact@centrale-autocar.com&nbsp;</p><p>Veuillez agréer, Madame, Monsieur, l\'expression de nos salutations distinguées.</p><p> </p><p>{commercial.signature}&nbsp;}&nbsp;</p>','created_at' => '2022-02-09 22:08:03','updated_at' => '2022-03-18 12:02:01','subject' => 'Centrale Autocar Fidélisation {dossier.ref}'),
            array('id' => '3','title' => 'Relance','content' => '<p>Bonjour</p><p>Je revenais simplement aux nouvelles concernant votre transfert en autocar</p><p>Merci de bien vouloir me recontacter au {commercial.phone}&nbsp;</p><p>Au plaisir de vous entendre !</p><p>{commercial.signature}&nbsp;}&nbsp;</p>','created_at' => '2022-03-18 11:56:38','updated_at' => '2022-03-18 12:01:51','subject' => 'Relance de votre projet de transfert en Autocar {dossier.ref}'),
            array('id' => '4','title' => 'Vos infos voyages','content' => '<p>Bonjour,</p><p>Afin de bien préparer votre voyage merci de bien vouloir me faire parvenir au plus vite les informations suivantes.</p><p>- Date,Adresse et heure de prise en charge:</p><p>- Adresse&nbsp; de destination:</p><p>-Date, Heure et lieu de ramassage pour le retour :</p><p>- Nombre de participants:</p><p>- Nom et numéro du contact sur place</p><p>- Un chèque de caution de 500 €/par car vous sera demandé lors de votre premier transfert et vous sera rendu en fin de service après l\'état des lieux de(s) autocar(s)</p><p>****Pour rappel, le port du masque est obligatoire dans le car, et ce pendant toute la durée du trajet****</p><p> </p><p>Liste personnes transportées : Suite à l’arrêté du 18/05/09, et pour tout transport hors département et départements limitrophes, nous vous remercionsde nous fournir au départ du car, une liste des passagers (Nom – Prénom), sur papier à en-tête ou sur papier libre, avec le nom de l’organisateur. S’’il s’agit d’enfants, ajouter le numéro de téléphone de leur référent.</p><p>Lors du chargement du groupe, votre responsable devra noter sur la feuille le numéro d’immatriculation et remettre le document à notre conducteur. Merci de votre contribution et compréhension, ce document étant obligatoire en cas de contrôle routier.</p><p>Merci d\'avance</p><p>{utilisateur.signature}&nbsp;</p>','created_at' => '2022-03-18 11:58:17','updated_at' => '2022-03-18 11:59:55','subject' => 'Vos informations voyages {dossier.ref}'),
            array('id' => '5','title' => 'Régularisation Solde et informations voyages','content' => '<p>{client.salutation}&nbsp;</p><p>Sauf erreur ou omission de notre part, nous constatons que votre compte client présente à ce jour un solde débiteur de ... Euros&nbsp;</p><p>Ce montant correspond à votre transfert en autocar du :....</p><p>Votre transfert approchant à grand pas, nous vous demandons de bien vouloir regulariser la situation.&nbsp;</p><p>Pour rappel, voici nos coordonnées bancaires:</p><p>Ci dessous notre RIB:</p><p>Iban : FR76 3000 4015 9600 0101 0820 195</p><p>BIC: BNPAFRPPXXX</p><p>Code Banque: 30004</p><p>Code Guichet: 01596</p><p>Numéro de compte: 00010108201</p><p>Clé RIB: 95</p><p>Titulaire du compte: Centrale Autocar</p><p> </p><p>Dans le cas où votre règlement aurait été adressé entre temps, nous vous prions de ne pas tenir compte de la présente.</p><p>D\'autre part, nous ne disposons toujours pas de vos informations voyageurs, indispensables a la mise en place de votre transfert.Merci de nous retourner le document rempli des reception de cet email.</p><p>Vous remerciant par avance, nous vous prions d\'agréer, Monsieur,Madame,&nbsp; l’expression de nos salutations distinguées.</p><p>{utilisateur.signature}&nbsp;</p>','created_at' => '2022-03-18 11:59:45','updated_at' => '2022-03-18 12:00:04','subject' => 'Régularisation Solde et informations voyages {dossier.ref}')
        );

        foreach ($templates as $template){
            Template::create($template);
        }


        /* `crmautocar`.`roles` */
        $roles = array(
            array('id' => '7','name' => 'Résa','guard_name' => 'web','created_at' => '2022-03-15 11:56:49','updated_at' => '2022-03-15 11:56:49'),
            array('id' => '8','name' => 'Bureau 1','guard_name' => 'web','created_at' => '2022-04-03 00:07:40','updated_at' => '2022-04-03 00:07:40'),
            array('id' => '9','name' => 'Bureau 2','guard_name' => 'web','created_at' => '2022-04-03 00:07:50','updated_at' => '2022-04-03 00:07:50'),
            array('id' => '10','name' => 'Bureau 3','guard_name' => 'web','created_at' => '2022-04-03 00:15:00','updated_at' => '2022-04-03 00:15:00'),
            array('id' => '11','name' => 'Bureau 4','guard_name' => 'web','created_at' => '2022-04-03 00:15:08','updated_at' => '2022-04-03 00:15:08')
        );

        foreach($roles as $role){
            Role::create($role);
        }


        /* `crmautocar`.`role_has_permissions` */
        $role_has_permissions = array(
            array('permission_id' => '1','role_id' => '1'),
            array('permission_id' => '1','role_id' => '2'),
            array('permission_id' => '1','role_id' => '5'),
            array('permission_id' => '2','role_id' => '1'),
            array('permission_id' => '2','role_id' => '2'),
            array('permission_id' => '2','role_id' => '5'),
            array('permission_id' => '3','role_id' => '1'),
            array('permission_id' => '3','role_id' => '2'),
            array('permission_id' => '3','role_id' => '5'),
            array('permission_id' => '4','role_id' => '1'),
            array('permission_id' => '4','role_id' => '2'),
            array('permission_id' => '4','role_id' => '5'),
            array('permission_id' => '5','role_id' => '1'),
            array('permission_id' => '5','role_id' => '2'),
            array('permission_id' => '5','role_id' => '5'),
            array('permission_id' => '6','role_id' => '1'),
            array('permission_id' => '6','role_id' => '2'),
            array('permission_id' => '6','role_id' => '5'),
            array('permission_id' => '7','role_id' => '1'),
            array('permission_id' => '7','role_id' => '2'),
            array('permission_id' => '7','role_id' => '5'),
            array('permission_id' => '8','role_id' => '1'),
            array('permission_id' => '8','role_id' => '2'),
            array('permission_id' => '8','role_id' => '5'),
            array('permission_id' => '9','role_id' => '1'),
            array('permission_id' => '9','role_id' => '2'),
            array('permission_id' => '9','role_id' => '5'),
            array('permission_id' => '10','role_id' => '1'),
            array('permission_id' => '10','role_id' => '2'),
            array('permission_id' => '10','role_id' => '5'),
            array('permission_id' => '11','role_id' => '1'),
            array('permission_id' => '11','role_id' => '2'),
            array('permission_id' => '11','role_id' => '5'),
            array('permission_id' => '12','role_id' => '1'),
            array('permission_id' => '12','role_id' => '2'),
            array('permission_id' => '12','role_id' => '5'),
            array('permission_id' => '13','role_id' => '1'),
            array('permission_id' => '13','role_id' => '2'),
            array('permission_id' => '13','role_id' => '5'),
            array('permission_id' => '14','role_id' => '1'),
            array('permission_id' => '14','role_id' => '2'),
            array('permission_id' => '14','role_id' => '5'),
            array('permission_id' => '15','role_id' => '1'),
            array('permission_id' => '15','role_id' => '2'),
            array('permission_id' => '15','role_id' => '5'),
            array('permission_id' => '16','role_id' => '1'),
            array('permission_id' => '16','role_id' => '2'),
            array('permission_id' => '16','role_id' => '5'),
            array('permission_id' => '17','role_id' => '1'),
            array('permission_id' => '17','role_id' => '2'),
            array('permission_id' => '17','role_id' => '5'),
            array('permission_id' => '18','role_id' => '1'),
            array('permission_id' => '18','role_id' => '2'),
            array('permission_id' => '18','role_id' => '5'),
            array('permission_id' => '19','role_id' => '1'),
            array('permission_id' => '19','role_id' => '2'),
            array('permission_id' => '19','role_id' => '5'),
            array('permission_id' => '20','role_id' => '1'),
            array('permission_id' => '20','role_id' => '2'),
            array('permission_id' => '20','role_id' => '5'),
            array('permission_id' => '21','role_id' => '2'),
            array('permission_id' => '21','role_id' => '5'),
            array('permission_id' => '22','role_id' => '2'),
            array('permission_id' => '22','role_id' => '5'),
            array('permission_id' => '23','role_id' => '2'),
            array('permission_id' => '23','role_id' => '5'),
            array('permission_id' => '24','role_id' => '2'),
            array('permission_id' => '24','role_id' => '5'),
            array('permission_id' => '25','role_id' => '2'),
            array('permission_id' => '25','role_id' => '5'),
            array('permission_id' => '26','role_id' => '2'),
            array('permission_id' => '26','role_id' => '5'),
            array('permission_id' => '27','role_id' => '2'),
            array('permission_id' => '27','role_id' => '5'),
            array('permission_id' => '28','role_id' => '2'),
            array('permission_id' => '28','role_id' => '5'),
            array('permission_id' => '29','role_id' => '2'),
            array('permission_id' => '29','role_id' => '5'),
            array('permission_id' => '30','role_id' => '2'),
            array('permission_id' => '30','role_id' => '5'),
            array('permission_id' => '31','role_id' => '2'),
            array('permission_id' => '31','role_id' => '5'),
            array('permission_id' => '32','role_id' => '2'),
            array('permission_id' => '32','role_id' => '5'),
            array('permission_id' => '33','role_id' => '2'),
            array('permission_id' => '33','role_id' => '5'),
            array('permission_id' => '34','role_id' => '2'),
            array('permission_id' => '34','role_id' => '5'),
            array('permission_id' => '35','role_id' => '2'),
            array('permission_id' => '35','role_id' => '5'),
            array('permission_id' => '36','role_id' => '5'),
            array('permission_id' => '37','role_id' => '5'),
            array('permission_id' => '38','role_id' => '5'),
            array('permission_id' => '39','role_id' => '5'),
            array('permission_id' => '40','role_id' => '5'),
            array('permission_id' => '41','role_id' => '5'),
            array('permission_id' => '42','role_id' => '5'),
            array('permission_id' => '43','role_id' => '5'),
            array('permission_id' => '44','role_id' => '5'),
            array('permission_id' => '45','role_id' => '5'),
            array('permission_id' => '46','role_id' => '5'),
            array('permission_id' => '47','role_id' => '5'),
            array('permission_id' => '48','role_id' => '5'),
            array('permission_id' => '49','role_id' => '5'),
            array('permission_id' => '50','role_id' => '5'),
            array('permission_id' => '51','role_id' => '5'),
            array('permission_id' => '52','role_id' => '5'),
            array('permission_id' => '53','role_id' => '5'),
            array('permission_id' => '54','role_id' => '5'),
            array('permission_id' => '55','role_id' => '5'),
            array('permission_id' => '56','role_id' => '5'),
            array('permission_id' => '57','role_id' => '5'),
            array('permission_id' => '58','role_id' => '5'),
            array('permission_id' => '59','role_id' => '5'),
            array('permission_id' => '60','role_id' => '5'),
            array('permission_id' => '61','role_id' => '3'),
            array('permission_id' => '61','role_id' => '5'),
            array('permission_id' => '61','role_id' => '6'),
            array('permission_id' => '61','role_id' => '7'),
            array('permission_id' => '62','role_id' => '3'),
            array('permission_id' => '62','role_id' => '5'),
            array('permission_id' => '62','role_id' => '6'),
            array('permission_id' => '62','role_id' => '7'),
            array('permission_id' => '63','role_id' => '3'),
            array('permission_id' => '63','role_id' => '5'),
            array('permission_id' => '63','role_id' => '7'),
            array('permission_id' => '64','role_id' => '3'),
            array('permission_id' => '64','role_id' => '5'),
            array('permission_id' => '64','role_id' => '6'),
            array('permission_id' => '64','role_id' => '7'),
            array('permission_id' => '65','role_id' => '3'),
            array('permission_id' => '65','role_id' => '5'),
            array('permission_id' => '65','role_id' => '6'),
            array('permission_id' => '65','role_id' => '7'),
            array('permission_id' => '66','role_id' => '3'),
            array('permission_id' => '66','role_id' => '5'),
            array('permission_id' => '67','role_id' => '3'),
            array('permission_id' => '67','role_id' => '5'),
            array('permission_id' => '67','role_id' => '6'),
            array('permission_id' => '67','role_id' => '7'),
            array('permission_id' => '68','role_id' => '3'),
            array('permission_id' => '68','role_id' => '5'),
            array('permission_id' => '68','role_id' => '6'),
            array('permission_id' => '68','role_id' => '7'),
            array('permission_id' => '69','role_id' => '3'),
            array('permission_id' => '69','role_id' => '5'),
            array('permission_id' => '69','role_id' => '7'),
            array('permission_id' => '70','role_id' => '3'),
            array('permission_id' => '70','role_id' => '5'),
            array('permission_id' => '70','role_id' => '6'),
            array('permission_id' => '70','role_id' => '7'),
            array('permission_id' => '71','role_id' => '3'),
            array('permission_id' => '71','role_id' => '5'),
            array('permission_id' => '71','role_id' => '6'),
            array('permission_id' => '71','role_id' => '7'),
            array('permission_id' => '72','role_id' => '3'),
            array('permission_id' => '72','role_id' => '5'),
            array('permission_id' => '73','role_id' => '3'),
            array('permission_id' => '73','role_id' => '5'),
            array('permission_id' => '73','role_id' => '6'),
            array('permission_id' => '73','role_id' => '7'),
            array('permission_id' => '74','role_id' => '3'),
            array('permission_id' => '74','role_id' => '5'),
            array('permission_id' => '74','role_id' => '6'),
            array('permission_id' => '74','role_id' => '7'),
            array('permission_id' => '75','role_id' => '3'),
            array('permission_id' => '75','role_id' => '5'),
            array('permission_id' => '75','role_id' => '6'),
            array('permission_id' => '75','role_id' => '7'),
            array('permission_id' => '76','role_id' => '3'),
            array('permission_id' => '76','role_id' => '5'),
            array('permission_id' => '76','role_id' => '6'),
            array('permission_id' => '76','role_id' => '7'),
            array('permission_id' => '77','role_id' => '3'),
            array('permission_id' => '77','role_id' => '5'),
            array('permission_id' => '78','role_id' => '3'),
            array('permission_id' => '78','role_id' => '5'),
            array('permission_id' => '78','role_id' => '6'),
            array('permission_id' => '78','role_id' => '7'),
            array('permission_id' => '79','role_id' => '3'),
            array('permission_id' => '79','role_id' => '5'),
            array('permission_id' => '79','role_id' => '6'),
            array('permission_id' => '79','role_id' => '7'),
            array('permission_id' => '80','role_id' => '3'),
            array('permission_id' => '80','role_id' => '5'),
            array('permission_id' => '80','role_id' => '6'),
            array('permission_id' => '80','role_id' => '7'),
            array('permission_id' => '81','role_id' => '3'),
            array('permission_id' => '81','role_id' => '5'),
            array('permission_id' => '81','role_id' => '6'),
            array('permission_id' => '81','role_id' => '7'),
            array('permission_id' => '82','role_id' => '3'),
            array('permission_id' => '82','role_id' => '5'),
            array('permission_id' => '83','role_id' => '3'),
            array('permission_id' => '83','role_id' => '5'),
            array('permission_id' => '83','role_id' => '6'),
            array('permission_id' => '83','role_id' => '7'),
            array('permission_id' => '84','role_id' => '3'),
            array('permission_id' => '84','role_id' => '5'),
            array('permission_id' => '84','role_id' => '6'),
            array('permission_id' => '84','role_id' => '7'),
            array('permission_id' => '85','role_id' => '3'),
            array('permission_id' => '85','role_id' => '5'),
            array('permission_id' => '85','role_id' => '6'),
            array('permission_id' => '85','role_id' => '7'),
            array('permission_id' => '86','role_id' => '3'),
            array('permission_id' => '86','role_id' => '5'),
            array('permission_id' => '86','role_id' => '6'),
            array('permission_id' => '86','role_id' => '7'),
            array('permission_id' => '87','role_id' => '3'),
            array('permission_id' => '87','role_id' => '5'),
            array('permission_id' => '87','role_id' => '6'),
            array('permission_id' => '87','role_id' => '7'),
            array('permission_id' => '88','role_id' => '3'),
            array('permission_id' => '88','role_id' => '5'),
            array('permission_id' => '89','role_id' => '3'),
            array('permission_id' => '89','role_id' => '5'),
            array('permission_id' => '89','role_id' => '7'),
            array('permission_id' => '90','role_id' => '3'),
            array('permission_id' => '90','role_id' => '5'),
            array('permission_id' => '90','role_id' => '7'),
            array('permission_id' => '91','role_id' => '3'),
            array('permission_id' => '91','role_id' => '5'),
            array('permission_id' => '91','role_id' => '7'),
            array('permission_id' => '92','role_id' => '3'),
            array('permission_id' => '92','role_id' => '5'),
            array('permission_id' => '92','role_id' => '7'),
            array('permission_id' => '93','role_id' => '3'),
            array('permission_id' => '93','role_id' => '5'),
            array('permission_id' => '94','role_id' => '5'),
            array('permission_id' => '94','role_id' => '7'),
            array('permission_id' => '95','role_id' => '5'),
            array('permission_id' => '95','role_id' => '7'),
            array('permission_id' => '96','role_id' => '5'),
            array('permission_id' => '96','role_id' => '7'),
            array('permission_id' => '97','role_id' => '5'),
            array('permission_id' => '97','role_id' => '7'),
            array('permission_id' => '98','role_id' => '5'),
            array('permission_id' => '99','role_id' => '3'),
            array('permission_id' => '99','role_id' => '7'),
            array('permission_id' => '100','role_id' => '3'),
            array('permission_id' => '100','role_id' => '6'),
            array('permission_id' => '100','role_id' => '7'),
            array('permission_id' => '101','role_id' => '3'),
            array('permission_id' => '101','role_id' => '7'),
            array('permission_id' => '102','role_id' => '3'),
            array('permission_id' => '102','role_id' => '6'),
            array('permission_id' => '102','role_id' => '7'),
            array('permission_id' => '103','role_id' => '3'),
            array('permission_id' => '104','role_id' => '3'),
            array('permission_id' => '105','role_id' => '3'),
            array('permission_id' => '105','role_id' => '6'),
            array('permission_id' => '105','role_id' => '7'),
            array('permission_id' => '106','role_id' => '3'),
            array('permission_id' => '106','role_id' => '6'),
            array('permission_id' => '106','role_id' => '7'),
            array('permission_id' => '107','role_id' => '3'),
            array('permission_id' => '107','role_id' => '6'),
            array('permission_id' => '107','role_id' => '7'),
            array('permission_id' => '108','role_id' => '3'),
            array('permission_id' => '108','role_id' => '6'),
            array('permission_id' => '108','role_id' => '7'),
            array('permission_id' => '109','role_id' => '3'),
            array('permission_id' => '110','role_id' => '3'),
            array('permission_id' => '110','role_id' => '6'),
            array('permission_id' => '110','role_id' => '7'),
            array('permission_id' => '111','role_id' => '3'),
            array('permission_id' => '111','role_id' => '6'),
            array('permission_id' => '111','role_id' => '7'),
            array('permission_id' => '112','role_id' => '3'),
            array('permission_id' => '112','role_id' => '6'),
            array('permission_id' => '112','role_id' => '7'),
            array('permission_id' => '113','role_id' => '3'),
            array('permission_id' => '113','role_id' => '6'),
            array('permission_id' => '113','role_id' => '7'),
            array('permission_id' => '114','role_id' => '3'),
            array('permission_id' => '115','role_id' => '3'),
            array('permission_id' => '115','role_id' => '6'),
            array('permission_id' => '115','role_id' => '7'),
            array('permission_id' => '116','role_id' => '3'),
            array('permission_id' => '116','role_id' => '6'),
            array('permission_id' => '116','role_id' => '7'),
            array('permission_id' => '117','role_id' => '3'),
            array('permission_id' => '117','role_id' => '6'),
            array('permission_id' => '117','role_id' => '7'),
            array('permission_id' => '118','role_id' => '3'),
            array('permission_id' => '118','role_id' => '6'),
            array('permission_id' => '118','role_id' => '7'),
            array('permission_id' => '119','role_id' => '3'),
            array('permission_id' => '119','role_id' => '6'),
            array('permission_id' => '119','role_id' => '7'),
            array('permission_id' => '120','role_id' => '3'),
            array('permission_id' => '120','role_id' => '6'),
            array('permission_id' => '120','role_id' => '7'),
            array('permission_id' => '121','role_id' => '3'),
            array('permission_id' => '121','role_id' => '6'),
            array('permission_id' => '121','role_id' => '7'),
            array('permission_id' => '122','role_id' => '3'),
            array('permission_id' => '123','role_id' => '3'),
            array('permission_id' => '123','role_id' => '6'),
            array('permission_id' => '123','role_id' => '7'),
            array('permission_id' => '124','role_id' => '3'),
            array('permission_id' => '124','role_id' => '6'),
            array('permission_id' => '124','role_id' => '7'),
            array('permission_id' => '125','role_id' => '3'),
            array('permission_id' => '125','role_id' => '7'),
            array('permission_id' => '126','role_id' => '3'),
            array('permission_id' => '126','role_id' => '7'),
            array('permission_id' => '127','role_id' => '3'),
            array('permission_id' => '128','role_id' => '3'),
            array('permission_id' => '128','role_id' => '6'),
            array('permission_id' => '128','role_id' => '7'),
            array('permission_id' => '129','role_id' => '3'),
            array('permission_id' => '129','role_id' => '6'),
            array('permission_id' => '129','role_id' => '7'),
            array('permission_id' => '130','role_id' => '3'),
            array('permission_id' => '130','role_id' => '6'),
            array('permission_id' => '130','role_id' => '7'),
            array('permission_id' => '131','role_id' => '3'),
            array('permission_id' => '131','role_id' => '6'),
            array('permission_id' => '131','role_id' => '7'),
            array('permission_id' => '132','role_id' => '3'),
            array('permission_id' => '133','role_id' => '3'),
            array('permission_id' => '133','role_id' => '7'),
            array('permission_id' => '134','role_id' => '3'),
            array('permission_id' => '134','role_id' => '6'),
            array('permission_id' => '134','role_id' => '7'),
            array('permission_id' => '135','role_id' => '3'),
            array('permission_id' => '135','role_id' => '7'),
            array('permission_id' => '136','role_id' => '3'),
            array('permission_id' => '136','role_id' => '6'),
            array('permission_id' => '136','role_id' => '7'),
            array('permission_id' => '137','role_id' => '3'),
            array('permission_id' => '137','role_id' => '7'),
            array('permission_id' => '138','role_id' => '3')
        );


        DB::table("role_has_permissions")->delete();
        foreach($role_has_permissions as $permission){
            DB::table("role_has_permissions")->insert($permission);
        }


    }
}
