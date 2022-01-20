<?php

namespace Modules\CrmAutoCar\Notifications;

use Illuminate\Support\Carbon;
use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Flow\Notification\Notif;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierAttribuer;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;
use Modules\CrmAutoCar\Mail\DevisSendClientMail;

class DossierAttribuerNotification extends Notif
{

    public function listenFlow(): array
    {
        return [
            ClientDossierAttribuer::class
        ];
    }

    public function handle(): void
    {
        $dossier = $this->flow->datas->getDossier();
        $commercial = $this->flow->datas->getCommercial();
        $commercial->notify($this);
    }

    public function via($notifiable){
        return ['database'];
    }


    public function toArray($notifiable){
        /** @var \Modules\CrmAutoCar\Flow\Attributes\ClientDossierAttribuer $flowAttributes */
        $flowAttributes = $this->flow->datas;
        return [
            'url' => route('dossiers.show', [
                $flowAttributes->getDossier()->client,
                $flowAttributes->getDossier(),
            ]),
            'image' => $flowAttributes->getDossier()->client->avatar_url,
            'title' => 'Nouveau dossier #' . $flowAttributes->getDossier()->ref ,
            'content' => $flowAttributes->getAttributeur()->format_name . ' vous à attribuer un nouveau dossier #' . $flowAttributes->getDossier()->ref .' pour le client ' . $flowAttributes->getDossier()->client->format_name
        ];
    }

}
