<?php
namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FactureMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Commande $commande,
        public $pdf
    ) {}

    public function build() {
        return $this->subject('Votre facture ISI BURGER #' . $this->commande->id)
            ->view('emails.facture')
            ->attachData($this->pdf->output(), 'facture_' . $this->commande->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
