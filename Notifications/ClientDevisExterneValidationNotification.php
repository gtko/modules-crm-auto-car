<?php

namespace Modules\CrmAutoCar\Notifications;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\BaseCore\Models\User;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Flow\Attributes\ClientDossierDevisCreate;
use Modules\CoreCRM\Flow\Notification\Notif;
use Modules\CoreCRM\Models\Commercial;
use Modules\CrmAutoCar\Flow\Attributes\ClientDevisExterneValidation;
use Modules\CrmAutoCar\Mail\AccepteDevisClientMail;
use Modules\CrmAutoCar\Mail\AccepteDevisConseillerMail;


class ClientDevisExterneValidationNotification extends Notif
{

    public function listenFlow(): array
    {
        return [
            ClientDevisExterneValidation::class
        ];
    }

    public function handle(): void
    {

        $this->flow->datas->getDevis()->dossier->commercial->notify($this);
        $this->flow->datas->getDevis()->dossier->client->notify($this);

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($notifiable instanceof Commercial)
        {
            return ['database', 'mail'];
        }
        return ['mail'];

    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toMail(mixed $notifiable)
    {
        $flowAttributes = $this->flow->datas;



        if($notifiable instanceof Commercial)
        {
            return  (new AccepteDevisConseillerMail($flowAttributes->getDevis(), $flowAttributes->getIp()))->to($notifiable->email);
        } else {

            $pdfService = app(PdfContract::class);
            $pdfService->setUrl((new GenerateLinkDevis)->GenerateLinkPDF($flowAttributes->getDevis()));
            $pdf = $pdfService->getContentPdf();

            return (new AccepteDevisClientMail($flowAttributes->getDevis(), $flowAttributes->getIp()))->to($notifiable->email)->attachData($pdf, 'name.pdf', [
                'mime' => 'application/pdf',
            ])->attachData($pdf, 'name.pdf', [
                'mime' => 'application/pdf',
            ]);
        }

    }

    public function toArray($notifiable): array
    {
        /** @var ClientDossierDevisCreate $flowAttributes */
        $flowAttributes = $this->flow->datas;

        return [
            'url' => route('dossiers.show', [
                $flowAttributes->getDevis()->dossier->client,
                $flowAttributes->getDevis()->dossier,
            ]),
            'image' => $flowAttributes->getDevis()->dossier->client->avatar_url,
            'title' => 'Devis #' . $flowAttributes->getDevis()->ref . 'validé par le client',
            'content' => 'Le client ' . $flowAttributes->getDevis()->dossier->client->formatName . ' a validé le devis #' . $flowAttributes->getDevis()->ref
        ];
    }
}
