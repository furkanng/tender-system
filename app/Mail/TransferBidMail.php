<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TransferBidMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $address;
    public $tender_no;
    public $tender_car_name;
    public $tender_image;
    public $bid_price;

    public function __construct($name, $address,$tender_car_name,$tender_no,$tender_image,$bid_price)
    {
        $this->name = $name;
        $this->address = $address;
        $this->tender_no=$tender_no;
        $this->tender_image=$tender_image;
        $this->bid_price=$bid_price;
        $this->tender_car_name = $tender_car_name;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->address,
            subject: "Oto İhale Sistemine Hoşgeldiniz",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: "template.transferBid",
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
