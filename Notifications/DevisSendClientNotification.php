<?php

namespace Modules\CrmAutoCar\Notifications;

use Illuminate\Support\Carbon;
use Modules\BaseCore\Contracts\Services\PdfContract;
use Modules\CoreCRM\Actions\Devis\GenerateLinkDevis;
use Modules\CoreCRM\Flow\Notification\Notif;
use Modules\CrmAutoCar\Flow\Attributes\DevisSendClient;
use Modules\CrmAutoCar\Mail\DevisSendClientMail;

class DevisSendClientNotification extends Notif
{

    public function listenFlow(): array
    {
        return [
            DevisSendClient::class
        ];
    }

    public function handle(): void
    {
        $dossier = $this->flow->datas->getDevis()->dossier;
        $dossier->commercial->notify($this);
        $dossier->client->notify($this);
    }

    public function via($notifiable){
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $devis = $this->flow->datas->getDevis();
        $pdfService = app(PdfContract::class);
        $pdfService->setUrl((new GenerateLinkDevis)->GenerateLinkPDF($devis));
        $pdf = $pdfService->getContentPdf();

        return (new DevisSendClientMail($this->flow->datas->getDevis()))
            ->to($notifiable->email)
            ->attachData($pdf,'devis-'.$devis->ref.'-'.Carbon::now()->format('d_m_y-hm').'.pdf',
                [
                    'mime' => 'application/pdf',
                ]
            );
    }

    public function toArray($notifiable){
        /** @var \Modules\CrmAutoCar\Flow\Attributes\DevisSendClient $flowAttributes */
        $flowAttributes = $this->flow->datas;
        return [
            'url' => route('dossiers.show', [
                $flowAttributes->getDevis()->dossier->client,
                $flowAttributes->getDevis()->dossier,
            ]),
            'image' => $flowAttributes->getDevis()->dossier->client->avatar_url,
            'title' => 'Envoie du devis #' . $flowAttributes->getDevis()->ref .' au client',
            'content' => 'Le devis #' . $flowAttributes->getDevis()->ref .' à été envoyé au client ' . $flowAttributes->getDevis()->dossier->client->format_name
        ];
    }

}
