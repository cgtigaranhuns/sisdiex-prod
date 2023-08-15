<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulário para o Q-Acadêmico</title>

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid black;
            font-size: 10pt;
        }

       
        td {
            border-collapse: collapse;
            width: 80%;
            border: 1px solid black;
        }

        th {
            text-align: right;
            border-collapse: collapse;
            width: 20%;
            border: 1px solid black;
        }

        
    </style>

</head>

<body>


    <div class="container-fluid">
        <table style="width: 100%; border: 0px">
            <tr style="border: 0px">
                <td style="border: 0px">
                    <img src="{{ asset('img/logo-ifpe.png') }}" alt="Logo" class="img-fluid" width="150"
                        height="200">
                </td>
                <td style="border: 0px">
                    <h3 style="text-align: center; font-size: 20pt;">Formulário para cadastro no Q-Acadêmico</h3>
                    <h3 style="text-align: center; font-size: 12pt;">Gerado em: {{\Carbon\Carbon::today()->formatLocalized('%d de %B de %Y')}}</h3>
                </td>
            </tr>
        </table>
    
    
        <p>Evento/Ação</p>
        <table>
            <tr>
                <th>Propronente</th>
                <td>
                    {{ $acao->User->name }}
                </td>
            </tr>
            <tr>
               <th>Título</th>
               <td>
                    {{ $acao->titulo }}
                </td>
            </tr>
            <tr>
                <th>Temática</th>
                <td>
                    {{ $acao->AreaTematica->nome }}
                </td>
            </tr>
            <tr>
               <th>Atividade Relativa</th>
               <td>
                    {{ $atividadeRelativa }}
                </td>
            </tr>
            <tr>
                <th>Duração da Aula</th>
                <td>
                    {{ $duracaoAula }}
                </td>
            </tr>
            <tr>
               <th>Carga Horária Total</th>
               <td>
                    {{ $acao->carga_hr_total }}
                </td>
            </tr>

            <tr>
                <th>Data Início</th>
                <td>
                    {{\Carbon\Carbon::parse($acao->data_inicio)->format('d/m/Y')}}
                </td>
            </tr>
            <tr>
               <th>Data Fim</th>
               <td>
                    {{\Carbon\Carbon::parse($acao->data_fim)->format('d/m/Y')}}
                </td>
            </tr>
            <tr>
                <th>Hora Início</th>
                <td>
                    {{ $acao->hora_inicio }}
                </td>
            </tr>
            <tr>
               <th>Hora Fim</th>
               <td>
                    {{ $acao->hora_encerramento }}
                </td>
            </tr>
            <tr>
                <th>Modalidade</th>
                <td>
                    {{ $modalidade }}
                </td>
            </tr>
            <tr>
               <th>Turno</th>
               <td>
                    {{ $turno }}
                </td>
            </tr>
            <tr>
                <th>Periocidade</th>
                <td>
                    {{ $periocidade }}
                </td>
            </tr>
            <tr>
               <th>Critério de Aprovação</th>
               <td>
                    {{ $acao->criterio_aprovacao }}
                </td>
            </tr>
            <tr>
                <th>Frquência Mínima</th>
                <td>
                    {{ $acao->frequencia_minima }}
                </td>
            </tr>
            <tr>
                <th>Média de Aprovação</th>
                <td>
                    {{ $acao->media_aprovacao }}
                </td>
            </tr>
            <tr>
                <th>Forma de Avaliação</th>
                <td>
                    {{ $acao->forma_avaliacao }}
                </td>
            </tr>
            <tr>
                <th>Matriz Curricular</th>
                <td>
                    <label style="color: red">O diário de classe terá o mesmo título e carga horária do curso.</label>
                </td>
            </tr>
            <tr>
                <th>Justificativa</th>
                <td>
                    {{ $acao->justificativa }}
                </td>
            </tr>
            <tr>
                <th>Objetivo Geral</th>
                <td>
                    {{ $acao->objetivo_geral }}
                </td>
            </tr>
            <tr>
                <th>Objetivo Específico</th>
                <td>
                    {{ $acao->objetivo_especifico}}
                </td>
            </tr>
            <tr>
                <th>Metodologia</th>
                <td>
                    {{ $acao->metodologia}}
                </td>
            </tr>
            <tr>
                <th>Bibliografia</th>
                <td>
                    {{ $acao->bibliografia}}
                </td>
            </tr>
        </table>
        <p>Conteúdo Programático</p>
        <table>

              <table class="table" style="font-size: 8pt">
                    <tr style="text-align: center">
                                <th style="text-align: center">Ministrante</b></th>
                                <th style="text-align: center">CPF</b></th>
                                <th style="text-align: center">Ementa</b></th>
                                <th style="text-align: center">Email</b></th>
                                <th style="text-align: center">Data Ínicio</b></th>
                                <th style="text-align: center">Data Fim</b></th>
                                <th style="text-align: center">Carga Horário</th>
                    <tr>
                    
                        @foreach ($acao->ConteudoProgramatico as $cp )
                        <tr>
                        
                            <td>
                                {{$cp->ministrante}}
                             </td>
                             <td style="text-align: center">
                                {{$cp->cpf}}
                             </td>
                             <td>
                                {{$cp->ementa}}
                             </td>
                             <td>
                                {{$cp->email}}
                             </td>
                             <td  style="text-align: center">
                                {{\Carbon\Carbon::parse($cp->data_inicio)->format('d/m/Y')}}
                             </td>
                             <td  style="text-align: center">
                                {{\Carbon\Carbon::parse($cp->data_termino)->format('d/m/Y')}}
                             </td>
                             <td>
                                {{$cp->carga_horaria}}
                             </td>
                        
                    </tr>
                    @endforeach
                          
            </tr>


        </table>
            
                
       



</body>

</html>
