<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home SISDIEX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>

<body>
    <div class="table-responsive container text-center" style="margin-top: 0.5%">
        <table class="table table-success ">
            <tr>
                <td class="text-end">
                    <img src="img/logo-ifpe.png" class="img-responsive" alt="Logo" width="150" height="200" />
                </td>
                <td class="fs-3 text-center align-middle text-secondary">
                    <p>SISDIEX - Sistema da Divisão de Extensão<br>
                        IFPE - Campus Garanhuns</p>
                    
                </td>
            </tr>
        </table>
    </div>

    <div class=" table-responsive container" style="margin-top: -0.5%">
                    <table class="table table-success height: 100%">

                        <tbody>
                            <tr>
                                <td style="align-items: flex-end;">
                               
                                    <div class="card bg-body-tertiary" style="width:20rem; height: 12rem;  float: right;">
                                        <!--   <img width="69" height="69" src="img/gestao.png" alt="add-bookmark--v1" /> -->
                                        <div class="card-body">
                                            <h5 class="card-title">SISDIEX - Gestão e Propostas</h5>
                                            <p class="card-text">Gestão e cadastro de Propostas para eventos e ações.</p>
                                            <br>
                                            <a href="{{ url('admin/login') }}" class="btn btn-success">Acessar</a>
                                        </div>
                                    </div>
                                 
                                </td>
                                <td>
                                    <div class="card bg-body-tertiary" style="width: 20rem; height: 12rem; float: left;">
                                        <!--      <img width="69" height="69" src="img/inscricao.png" alt="add-bookmark--v1"> -->
                                        <div class="card-body">
                                            <h5 class="card-title">SISDIEX - Inscrições e Certificados.</h5>
                                            <p class="card-text">Realize inscrições e baixe seus certificados.</p>
                                            <a href="{{url('https://sisdiex.garanhuns.ifpe.edu.br')}}" class="btn btn-success">Acessar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="card bg-body-tertiary" style="width: 20rem; height: 12rem; float: right; ">
                                        <!--   <img width="69" height="69" src="img/consulta.png" alt="add-bookmark--v1"> -->
                                        <div class="card-body">
                                            <h5 class="card-title">SISDIEX - Validar Certificado de Participação.</h5>
                                            <p class="card-text">Consulte a validade dos certificados de participação.</p>
                                            <a href="{{ route('ValidaCertificadoParticipante') }}" class="btn btn-success">Acessar</a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="card bg-body-tertiary" style="width: 20rem; height: 12rem; float: left;">
                                        <!--    <img width="69" height="69" src="img/consulta.png" alt="add-bookmark--v1"> -->
                                        <div class="card-body">
                                            <h5 class="card-title">SISDIEX - Validar Certificado de Ministrantes</h5>
                                            <p class="card-text">Consulte a validade dos certificados dos ministrantes.</p>
                                            <a href="{{ route('ValidaCertificadoMinistrante') }}" class="btn btn-success">Acessar</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                    <td colspan="2">
                        <div class="card bg-body-tertiary" style="width: 42rem; height: 10rem; margin-left: 19rem;">
                            <!--   <img width="69" height="69" src="img/consulta.png" alt="add-bookmark--v1"> -->
                            <div class="card-body">
                                <h5 class="card-title" style="color: brown;">SISDIEX - ATÉ 2023 - GERAR E VALIDAR CERTIFICADOS</h5>
                                <p class="card-text">Gere e consulte os certificados de participação de curso
                                    ou evento até dezembro de 2023.</p>
                                <a href="{{ route('ValidaCertificadoMinistrante') }}" class="btn btn-success">Acessar</a>
                            </div>
                        </div>
                    </td>

                </tr>

                        </tbody>
                    </table>
    </div>
    <div class=" table-responsive container text-end fs-6 opacity-50">
        Desenvolvido pela CGTI - IFPE Campus Garanhuns - 2023 - Versão 1.0
     <div>

     <div class=" table-responsive container text-center fs-6 opacity-70" style="margin-top: 20px">
     <p>INSTITUTO FEDERAL DE PERNAMBUCO - IFPE Campus Garanhuns<br>
     Rua Pe. Agobar Valença, s/n, Severiano de Moraes Filho, Garanhuns - PE CEP: 55299-390.<br> O acesso rodoviário se dá pela via PE 177.</p>
     
     <div>








        </div>









</body>

</html>