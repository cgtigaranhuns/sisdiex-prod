<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Validação de Certificado</title>

    <style>
       
        .tabela2 {
            border: 0px;
            border-style: solid;
            border-color: grey;
            width: 100%;
            margin-top: 5%;
            font-family: courier, Arial, Helvetica, sans-serif;
        }

        label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <table class="tabela2">
        <tr>
            <td>
                <img src="{{ asset('img/logo-ifpe.png') }}" alt="Logo" width="150" height="200">
            </td>    
            <td>
                <p style="width: 100%; font-size:22px; font-family: 'courier,arial,helvetica;  text-align: center;">Validação de Certificado - Ministrante</p>
            </td>    
        </tr>
    </table>
    <table class="tabela2">
        <tr>
            <td>
                A Divisão de Extensão (DIEX) do Campus Garanhuns - IFPE,  ratifica as informações contidas no certificado impresso sob código {{$cp->certificado_cod}} conforme abaixo:<br><br>
            </td>
        </tr>
        <tr>
            <td>
               <label>Nome:</label> {{$cp->ministrante}}
            </td>
        </tr>
        <tr>
            <td>
                <label>Evento/Ação:</label> {{$acao->titulo}}
            </td>
        </tr>
        <tr>
            <td>
                <label>Data de Emissão:</label> {{$cp->certificado_data}}
            </td>
        </tr>
    </table>

</body>
</html>