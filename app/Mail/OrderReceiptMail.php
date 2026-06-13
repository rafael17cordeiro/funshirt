<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderReceiptMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $pdfFilename;

    public function __construct($order, $pdfFilename)
    {
        $this->order = $order;
        $this->pdfFilename = $pdfFilename;
    }

    public function build()
    {
        return $this->subject('Recibo da sua encomenda #' . $this->order->id . ' - FunShirt')
            ->view('emails.order_receipt')
            // Usar o método nativo do Laravel para ir buscar ao Storage local
            ->attachFromStorageDisk('local', 'pdf_receipts/' . $this->pdfFilename, 'Fatura_FunShirt_' . $this->order->id . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}