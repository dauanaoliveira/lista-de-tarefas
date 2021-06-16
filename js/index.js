function Tarefas() {
    this.status = "pendente";
    this.tarefas = [];
    this.modalSupervisor = new bootstrap.Modal(document.getElementById('modal-supervisor'));
    this.init = function () {
        tarefas.listarTarefas();

        $('#tab-tarefas a').on('click', function (e) {
            e.preventDefault()
            tarefas.status = $(this).attr('aria-controls');
            tarefas.listarTarefas();
        })

        $(document).on('click', '.btn-editar', function(){
            const id = $(this).parents('tr').attr('id');
            const dados = $(tarefas.tarefas).filter((i, v) => v.id == id)[0];
            
            for (var [key, value] of Object.entries(dados)) {
                $('#form-tarefas .form-control[name="' + key + '"]').val(value)
            }

            $('#btn-salvar').addClass('d-none');
            $('#btn-alterar').removeClass('d-none');
        });

        $(document).on('click', '.btn-concluir', function(){
            const id = $(this).parents('tr').attr('id');
            const dados = $(tarefas.tarefas).filter((i, v) => v.id == id)[0];
            var params = {
                id,
                status_antigo: dados.status,
                status: 'concluida',
                numberOfChanges: dados.numberOfChanges
            }            
            tarefas.alterarStatusTarefa(params);
        });

        $(document).on('click', '.btn-voltar-pendente', function(){
            const id = $(this).parents('tr').attr('id');
            $('#form-supervisor .form-control[name="id"]').val(id);
            tarefas.modalSupervisor.show();
        });

        $(document).on('click', '.btn-voltar-pendente-supervisor', function(){
            if (tarefas.validarCampos('#form-supervisor')) {
                Swal.fire("Ops... !", 'Por favor preencha os campos necessários.', "warning");
            } else {
                var params = tarefas.getFormData($("#form-supervisor")[0]);
                const dados = $(tarefas.tarefas).filter((i, v) => v.id == params.id)[0];

                params['status_antigo'] = dados.status;
                params['status'] = 'pendente';
                params['numberOfChanges'] = dados.numberOfChanges;

                tarefas.alterarStatusTarefa(params);
            }
        });

        $( "#btn-salvar" ).click(function() {
            var email = $('#form-tarefas .form-control[name="email"]').val();
            tarefas.verificarEmail(email, 'cadastrarTarefa');
        });

        $( "#btn-alterar" ).click(function() {
            var email = $('#form-tarefas .form-control[name="email"]').val();
            tarefas.verificarEmail(email, 'alterarTarefa');
        });

        $( "#btn-em-tarefa" ).click(function() {
          tarefas.emTarefa();
        });
    }

    this.alterarStatusTarefa  = function (params) {
        tarefas.loadingOpen();
        tarefas.executarAPI('service/alterarStatusTarefa/', JSON.stringify(params), function (obj) {
            if (obj.success) {
                tarefas.status = params.status;             
                Swal.fire({
                    title: 'Sucesso',
                    text: "Status da tarefa alterado com sucesso!",
                    icon: 'success',
                    }).then((result) => {
                        $('#form-supervisor .form-control').val('');
                        tarefas.modalSupervisor.hide();
                        tarefas.listarTarefas();
                    })
            } else {
                Swal.fire('Ops... !', obj.message, "error");
            }
        });
    }

    this.alterarTarefa  = function () {
        tarefas.loadingOpen();
        if (tarefas.validarCampos('#form-tarefas')) {
            Swal.fire("Ops... !", 'Por favor preencha os campos necessários.', "warning");
        } else {
            var params = tarefas.getFormData($("#form-tarefas")[0]);

            tarefas.executarAPI('service/alterarTarefa/', JSON.stringify(params), function (obj) {
                if (obj.success) {
                    tarefas.status = 'pendente';
                    Swal.fire({
                        title: 'Sucesso',
                        text: "Tarefa alterada com sucesso!",
                        icon: 'success',
                      }).then((result) => {
                          $('#form-tarefas .form-control').val('');
                          $('#btn-alterar').addClass('d-none');
                          $('#btn-salvar').removeClass('d-none');
                          tarefas.listarTarefas();
                      })
                } else {
                    tarefas.loadingClose();
                    Swal.fire('Ops... !', 'Ocorreu um erro ao alterar a tarefa. Tente novamente ou entre em contato com o suporte.', "error");
                }
            });
        }
    }

    this.cadastrarTarefa = function () {
        tarefas.loadingOpen();
        if (tarefas.validarCampos('#form-tarefas')) {
            Swal.fire("Ops... !", 'Por favor preencha os campos necessários.', "warning");
            return;
        }else {
            var params = tarefas.getFormData($("#form-tarefas")[0]);
            params['status'] = 'pendente';

            tarefas.executarAPI('service/cadastrarTarefa/', JSON.stringify(params), function (obj) {
                if (obj.success) {
                    tarefas.status = 'pendente';
                    Swal.fire({
                        title: 'Sucesso',
                        text: "Tarefa cadastrada com sucesso!",
                        icon: 'success',
                      }).then((result) => {
                          tarefas.listarTarefas();
                          $('#form-tarefas .form-control').val('');
                      })
                } else {
                    tarefas.loadingClose();
                    Swal.fire('Ops... !', 'Ocorreu um erro ao cadastrar a tarefa. Tente novamente ou entre em contato com o suporte.', "error");
                }
            });
        }
    }

    this.cadastrarTarefas = function (params) {
        tarefas.executarAPI('service/cadastrarTarefas/', JSON.stringify(params), function (obj) {
            if (obj.success) {
                tarefas.status = 'pendente';
                Swal.fire({
                    title: 'Sucesso',
                    text: "Tarefas cadastradas com sucesso!",
                    icon: 'success',
                    }).then((result) => {
                        tarefas.listarTarefas();
                        $('#form-tarefas .form-control').val('');
                    })
            } else {
                tarefas.loadingClose();
                Swal.fire('Ops... !', 'Ocorreu um erro ao cadastrar a tarefa. Tente novamente ou entre em contato com o suporte.', "error");
            }
        });
    }

    this.listarTarefas = function () {
        tarefas.loadingOpen();
        var params = {
            status: tarefas.status
        }

        tarefas.executarAPI('service/listarTarefas/', JSON.stringify(params), function (obj) {
        if (obj.success) {
            $('#' + tarefas.status + '-tab').tab('show');

            if(obj.elements < 1) {
                $('#tarefas-' + tarefas.status + 's').html('<tr><td colspan="5" class="text-center">Não há tarefas ' + tarefas.status + "s</td></tr>");
                tarefas.tarefas = [];
                tarefas.loadingClose();
                return;
            }

            tarefas.tarefas = obj.elements;
            var html = tarefas.processarHtmlHandlebars('#template-tarefas-' + tarefas.status + 's', obj);
            $('#tarefas-' + tarefas.status + 's').html(html);
            $('[data-bs-toggle="tooltip"]').tooltip();
            tarefas.loadingClose();

        } else {
            tarefas.loadingClose();
            Swal.fire('Ops... !', 'Ocorreu um erro ao buscar os dados. Tente novamente ou entre em contato com o suporte.', "error");
        }
        });
    }

    this.verificarEmail = function (email, next) {
        tarefas.loadingOpen();
        if (tarefas.validarCampos('#form-tarefas')) {
            Swal.fire("Ops... !", 'Por favor preencha os campos necessários.', "warning");
            return;
        }

        service =  'https://apilayer.net/api/check?access_key=b20d81ef17bc80e3b0a2a03c032dd26a&email=' + email;

        var params = {"tipo":"api-email"};

        tarefas.executarAPI(service, JSON.stringify(params), function (obj) {
            if (obj.success) { 
                if (obj.format_valid === true && obj.mx_found == true) {
                    if(next == 'cadastrarTarefa') {
                        tarefas.cadastrarTarefa();
                    }else{
                        tarefas.alterarTarefa();
                    }
                }else{
                    tarefas.loadingClose();
                    var mensagem = obj.did_you_mean != '' && obj.did_you_mean != undefined ? 'Email inválido. Talvez você quis dizer "' + valido + '" ?' : "Email inválido! Digite o email corretamente.";
                    Swal.fire("Ops... !", mensagem, "warning");
                }

            } else {
                tarefas.loadingClose();
                Swal.fire('Ops... !', 'Ocorreu um erro ao verificar o email. Tente novamente ou entre em contato com o suporte.', "error");
                return false;
            }
        }, 'GET');
    }

    this.emTarefa = function (params) {
        tarefas.loadingOpen();

        service = 'https://cat-fact.herokuapp.com/facts/random?animal_type=dog&amount=3';

        tarefas.executarAPI(service, JSON.stringify({}), function (obj) {
            if (obj.success) {
                var params = [];

                for(var i = 0; i < obj.length; i++) {
                    var tempObj = {
                        task: obj[i].text,
                        description: obj[i].text,
                        user: 'Eu',
                        email: 'eu@me.com',
                        status: 'pendente'
                    }

                    params.push(tempObj);
                }

                tarefas.cadastrarTarefas(params);
            } else {
                tarefas.loadingClose();
                Swal.fire('Ops... !', 'Ocorreu um erro ao buscar dados. Tente novamente ou entre em contato com o suporte.', "error");
                return false;
            }
        }, 'GET');
    }

    this.executarAPI = function (service, params, callback, type) {
        var formData = new FormData();
        formData.append('params', params);

        type = type == undefined ||  type == '' ? 'POST' : type;
        
        $.ajax({
            url: service,
            type: type,
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus, xhr) {
                var retorno = tarefas.convertToJson(data);
                // if(params == '{"tipo":"api-email"}') {
                if(type == 'GET') {
                    retorno.success = true;
                }
                callback(retorno);
            },
            error: function (err) {
                callback({
                    'success': false,
                    'message': 'Não foi possível estabelecer uma conexão com o Banco de Dados. Verifique sua conexão com a internet, e recarregue a página novamente.'
                });
            }
        });
    }

    this.convertToJson = function (str) {
        try {
            return JSON.parse(str);
        } catch (e) {
            return str;
        }
    }

    this.processarHtmlHandlebars = function (script_id, elements) {
        var source = $(script_id).html();
        var template = Handlebars.compile(source);
        if (elements == "") {
            return source;
        } else {
            return template(elements);
        }
    }

    this.validarCampos = function (formulario, next) {
        var valido = false;
        $(formulario + ' .obrigatorio').each(function(){         
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                valido = true;
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        return valido;
    }

    this.getFormData = function (form) {
        var unindexed_array = $(form).serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }

    this.loadingOpen  = function () {
        $('#loading').removeClass('d-none');
    }

    this.loadingClose  = function() {
        $('#loading').addClass('d-none');
    }
}

var tarefas = new Tarefas();
tarefas.init();