<?php

namespace App\Mail;

use App\Models\Inscricao;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificadoNaoAprovadoParticipante extends Mailable
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
            subject: 'Certificado Não Aprovado',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        
        if($this->inscricao->inscricao_tipo == 1){
            $nomeInscrito = $this->inscricao->discente->name;
        }
        if($this->inscricao->inscricao_tipo == 2){
            $nomeInscrito = $this->inscricao->user->name;
        }
        if($this->inscricao->inscricao_tipo == 3){
            $nomeInscrito = $this->inscricao->nome;
        }

        //MOTIVO REPROVAÇÃO
       
        if($this->inscricao->motivo_reprovacao == 1){
            $motivoReprovacao = 'Falta';
        }
        if($this->inscricao->motivo_reprovacao == 2){
            $motivoReprovacao = 'Não Aproveitamento';
        }
        if($this->inscricao->motivo_reprovacao == 3){
            $motivoReprovacao = 'Desistência';
        }
        if($this->inscricao->motivo_reprovacao == 4){
            $motivoReprovacao = 'Evasão';
        }
       


        return new Content(
            view: 'email.CertificadoNaoAprovadoParticipante',
            

            with: [
               'titulo' => $this->inscricao->acao->titulo,
                'nomeInscrito' => $nomeInscrito,
              //  'motivoReprovacao' => $motivoReprovacao,

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
