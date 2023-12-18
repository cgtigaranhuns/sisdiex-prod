<?php

namespace App\Mail;

use App\Models\Inscricao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InscricaoStatus extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected Inscricao $inscricao)
     {}


    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Situação da sua inscrição',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    { 
      //  dd($this->inscricao->inscricao_tipo);
        if($this->inscricao->inscricao_tipo == 1){
            $nomeInscrito = $this->inscricao->discente->name;
        }
        if($this->inscricao->inscricao_tipo == 2){
            $nomeInscrito = $this->inscricao->user->name;
        }
        if($this->inscricao->inscricao_tipo == 3){
            $nomeInscrito = $this->inscricao->nome;
        }
        

        
        return new Content(
            view: 'email.InscricaoStatus',
            

            with: [
                'titulo' => $this->inscricao->acao->titulo,
                'nomeInscrito' => $nomeInscrito,     
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
        return [];
    }
}
