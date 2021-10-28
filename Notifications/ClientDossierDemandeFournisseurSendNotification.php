<?php

namespace Modules\CrmAutoCar\Notifications;

use Modules\BaseCore\Models\User;
use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisCreate;
use Modules\CoreCRM\Flow\Notification\Notif;
use Modules\CrmAutoCar\Flow\Attributes\ClientDossierDemandeFournisseurSend;

class ClientDossierDemandeFournisseurSendNotification extends Notif
{

    public function listenFlow(): array
    {
        return [
            ClientDossierDemandeFournisseurSend::class
        ];
    }

    public function handle():void
    {
        foreach(User::role(['super-admin'])->get() as $user){
            $user->notify($this);
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable): array
    {
        /** @var ClientDossierDevisCreate $flowAttributes */
        $flowAttributes =  $this->flow->datas;

        return [
            'url' => route('dossiers.show', [
                $flowAttributes->getDevis()->dossier->client,
                $flowAttributes->getDevis()->dossier,
            ]),
            'image' => $flowAttributes->getDevis()->dossier->client->avatar_url,
            'title' => 'Nouvelle demande fournisseur',
            'content' => 'Une nouvelle demande fournisseur a etait créé ' . $flowAttributes->getDevis()->dossier->client->format_name
        ];
    }
}
