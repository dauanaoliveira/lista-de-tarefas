<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Tarefas</title>

        <link rel="stylesheet" href="lib/bootstrap-5.0.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="lib/font-awesome/css/all.min.css">
        <link rel="stylesheet" href="lib/sweetalert/css/sweetalert2.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div id="loading" class="d-none"></div>
        <div class="body-content">
            <nav id="nav-principal" class="navbar navbar-expand-lg navbar-dark">
                <div class="container">
                    <a class="navbar-brand" href="#">Lista de Tarefas</a>
                    
                    <button id="btn-em-tarefa" class="btn rounded-pill btn-light px-4 ms-auto">Estou em tarefa</button>
                </div>
            </nav>

            <div class="container mt-3">
                <div class="row justify-content-center mt-4">
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <form id="form-tarefas" class="row" action="">
                                    <div class="form-group mb-3 col-12">
                                        <label for="tarefa">Tarefa <span class="text-danger">*</span></label>
                                        <input type="hidden" class="form-control" id="id" name="id">
                                        <input type="hidden" class="form-control" id="numberOfChanges" name="numberOfChanges" value="0">

                                        <input type="text" class="form-control obrigatorio" id="tarefa" name="task">
                                    </div>
                                    <div class="form-group mb-3 col-12">
                                        <label for="descricao">Descrição <span class="text-danger">*</span></label>
                                        <textarea type="text" class="form-control obrigatorio" id="descricao" name="description" rows="3"></textarea>
                                    </div>
                                    <div class="form-group mb-3 col-md-5">
                                        <label for="usuario">Usuário <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control obrigatorio" id="usuario" name="user">
                                    </div>
                                    <div class="form-group mb-3 col-md-7">
                                        <label for="email">E-mail <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control obrigatorio" id="email" name="email">
                                    </div>
                                    <div class="col-12">
                                        <small>Dados com <span class="text-danger">*</span> são de preenchimento obrigatório.</small>
                                    </div>
                                    <div class="col-12 text-end">
                                        <button type="button" id="btn-salvar" class="btn rounded-pill btn-primary px-4">Cadastrar Tarefa</button>
                                        <button type="button" id="btn-alterar" class="btn rounded-pill btn-primary px-4 d-none">Alterar Tarefa</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">

                        <ul class="nav nav-tabs" id="tab-tarefas" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pendente-tab" data-toggle="tab" href="#pendente" role="tab" aria-controls="pendente" aria-selected="true">Tarefas Pendentes</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="concluida-tab" data-toggle="tab" href="#concluida" role="tab" aria-controls="concluida" aria-selected="false">Tarefas Concluídas</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="pendente" role="tabpanel" aria-labelledby="pendente-tab">
                                <div class="table-responsive">
                                    <table id="table-tarefas-pendentes" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col" width="20%">Tarefa</th>
                                            <th scope="col" width="35%">Descrição</th>
                                            <th scope="col" width="15%">Usuário</th>
                                            <th scope="col" width="20%">Email</th>
                                            <th scope="col" width="10%">Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tarefas-pendentes"></tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="concluida" role="tabpanel" aria-labelledby="concluida-tab">
                                <div class="table-responsive">
                                    <table id="table-tarefas-concluidas" class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th scope="col" width="20%">Tarefa</th>
                                            <th scope="col" width="35%">Descrição</th>
                                            <th scope="col" width="15%">Usuário</th>
                                            <th scope="col" width="20%">Email</th>
                                            <th scope="col" width="10%">Ações</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tarefas-concluidas"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer">
                <img src="img/wave.svg" alt="">
            </div>
        </div>
        
        <div id="modal-supervisor" class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Liberação do Supervisor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </button>
                </div>
                <div class="modal-body"> 
                    <form id="form-supervisor" class="row" action="">
                        <div class="form-group mb-3 col-12">
                            <input type="hidden" class="form-control" name="id">
                            <label for="tarefa">Senha de liberação <span class="text-danger">*</span></label>
                            <input type="password" class="form-control obrigatorio" id="senha" name="senha">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>

                    <button type="button" class="btn btn-primary rounded-pill px-4 btn-voltar-pendente-supervisor">Alterar status</button>
                </div>
                </div>
            </div>
        </div>        
    </body>

    <script src="lib/bootstrap-5.0.1/js/popper.js"></script>
    <script src="lib/bootstrap-5.0.1/js/bootstrap.min.js"></script>
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/handlebars-4.0.5/handlebars-4.0.5.min.js"></script>
    <script src="lib/font-awesome//js/all.min.js"></script>
    <script src="lib/sweetalert/js/sweetalert2.all.min.js"></script>
    <script src="js/index.js"></script>

    <script id="template-tarefas-pendentes" type="text/x-handlebars-template">
        {{#each elements}}
        <tr id="{{id}}">
            <td scope="row" data-key="task">{{task}}</td>
            <td scope="row" data-key="description">{{description}}</td>
            <td scope="row" data-key="user">{{user}}</td>
            <td scope="row" data-key="email">{{email}}</td>
            <td>
                <div class="d-flex justify-content-center">
                    <button class="btn-icons btn-concluir btn btn-success rounded-circle mx-1" data-bs-toggle="tooltip" title="Concluir"><i class="fa fa-check"></i></button>
                    <button class="btn-icons btn-editar btn btn-primary rounded-circle mx-1" data-bs-toggle="tooltip" title="Editar"><i class="fa fa-pen"></i></button>
                </div>
            </td>
        </tr>
        {{/each}}
    </script>

    <script id="template-tarefas-concluidas" type="text/x-handlebars-template">
        {{#each elements}}
        <tr id="{{id}}">
            <td scope="row" data-key="task">{{task}}</td>
            <td scope="row" data-key="description">{{description}}</td>
            <td scope="row" data-key="user">{{user}}</td>
            <td scope="row" data-key="email">{{email}}</td>
            <td>
                <div class="d-flex justify-content-center">
                    <button class="btn-icons btn-voltar-pendente btn btn-warning rounded-circle mx-1" data-bs-toggle="tooltip" title="Voltar para pendente"><i class="fa fa-exclamation"></i></button>
                </div>
            </td>
        </tr>
        {{/each}}
    </script>
</html>