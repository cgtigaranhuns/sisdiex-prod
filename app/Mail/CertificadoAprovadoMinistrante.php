<?php

namespace App\Mail;

use App\Models\ConteudoProgramatico;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificadoAprovadoMinistrante extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected ConteudoProgramatico $conteudoProgramatico)
    {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Certificado Liberado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.CertificadoAprovadoMinistrante',
            with: [
                'nome' => $this->conteudoProgramatico->ministrante,
                'titulo' => $this->conteudoProgramatico->acao->titulo,
                   
             ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromPath(public_path('/certificados/'.$this->conteudoProgramatico->certificado_cod.'.pdf'))
                ->as('certificado.pdf')
                ->withMime('application/pdf'),
            ];
    }
}
