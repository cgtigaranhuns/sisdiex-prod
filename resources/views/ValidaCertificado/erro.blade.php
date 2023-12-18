<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>Validação de Certificado</title>
    <script>
    function volta(){

        window.history.back();
    }
    </script>

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
                   
                        <p class="fs-2 text-center">Validação de Certificado</p>
                        <p class="fs-4 text-center">DIEX - Divisão de Extensão</p>
                   
                </td>    
            </tr>
        </table>
        <p class="fs-2 text-center text-secondary">CERTIFICADO NÃO ENCONTRADO</p>
        
        <a onclick="volta()" class="btn btn-secondary float-end">Voltar</a>
        
  
</body>
</html>