<?php

namespace App\Notifications;

use App\Models\Relance;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class RelanceReminderNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Relance $relance
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification (stored in DB).
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $f = $this->relance->facture;
        return [
            'type' => 'relance_reminder',
            'relance_id' => $this->relance->id,
            'date_relance' => $this->relance->date_relance,
            'motif_relance' => $this->relance->motif_relance,
            'commentaire' => $this->relance->commentaire,
            'facture_numero' => $f ? $f->numero_facture : null,
            'facture_client' => $f ? $f->client : null,
            'message' => 'Rappel : ' . ($this->relance->motif_relance ?? 'Relance') . ' – ' . ($f ? $f->numero_facture . ' (' . $f->client . ')' : ''),
        ];
    }
}
