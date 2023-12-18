<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Validação de Certificado</title>

    <style>
       
        .tabela2 {
            border: 0px;
            border-style: solid;
            border-color: grey;
            width: 100%;
            height: 100%;
            margin-top: 5%;
            font-family: courier, Arial, Helvetica, sans-serif;
        }

        .container {
            width: 50%;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 5px;
            margin: 0 auto;
            margin-top: 50px;
    }
    </style>
</head>
<body>
    

    <div class="container-sm">
        <table class="tabela2">
            <tr>
                <td>
                    <img src="{{ asset('img/logo-ifpe.png') }}" alt="Logo" class="img-fluid" width="150" height="200">
                </td>    
                <td>
                   
                        <p class="fs-2 text-center">Validação de Certificado - Participante</p>
                        <p class="fs-4 text-center">DIEX - Divisão de Extensão</p>
                   
                </td>    
            </tr>
        </table>
        <form action="{{ route('validarParticipante') }}" method="POST">
            @csrf
            <div class="mb-3">
               <input type="text" class="form-control" name="codigo" placeholder="Digite o código do certificado">
            </div>
               <button type="submit" class="btn btn-success float-end">Consultar</button>
        </form>
  
</body>
</html>