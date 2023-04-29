<?php

namespace App\Mail;

use App\Models\FastboatTrack;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderInvoice extends Mailable
{
    use Queueable, SerializesModels;

    protected $ticketPath = null;
    /**
     * Create a new message instance.
     */
    public function __construct(
        public $order
    ) {
        $item = $order->items()->first();

        if ($item->entity_order === FastboatTrack::class) {
            $this->ticketPath = 'tickets/'.$order->id.'.pdf';

            Pdf::loadView('pdf.ticket', ['item' => $item])
            ->setPaper([0,0,850,350])
            ->save($this->ticketPath);
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Order Invoice #'.$this->order->order_code,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.invoice',
            with: [
                'order' => $this->order,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->ticketPath != null) {
            return [
                Attachment::fromPath(public_path($this->ticketPath))
                    ->as('ticket-#'.$this->order->code.'.pdf')
                    ->withMime('application/pdf'),
            ];
        }

        return [];
    }
}
