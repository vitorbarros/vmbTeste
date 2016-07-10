$(document).ready(function () {
    //configuração do menu lateral Client
    var urlApp = window.location.pathname;
    var reApp = /sintegra/g;
    var mApp;

    while ((mApp = reApp.exec(urlApp)) !== null) {
        $("#" + mApp).attr('class', 'active');
    }
});

function auth() {
    var formData = new FormData($("#loginForm")[0]);
    $.ajax({
        type: "POST",
        url: "/login",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            window.location.href = data.redirect;
        },
        error: function (data) {
            if (!data.responseJSON.messages) {
                $.each(data.responseJSON, function (index, value) {
                    $("#" + index).css({"background-color": "rgb(242, 222, 222)"});
                });
                alertRequests('danger', 'Preencha os campos em vermelho', 'alert-login');
            } else {
                alertRequests('danger', data.responseJSON.messages, 'alert-login');
            }
        }
    });
}

var cnpj = null;
var token = null;

function consulta() {
    var formData = new FormData($("#consultaForm")[0]);

    cnpj = $("input[name='cnpj']").val();
    token = $("input[name='_token']").val();

    $("input[name='cnpj']").removeAttr('style');
    $("#alert-consulta").empty();

    var btn = $('input[value="Consultar"]').clone();

    $.ajax({
        type: "POST",
        url: "/app/sintegra/sintegra-request",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function () {
            $('input[value="Consultar"]').remove();
            $("#consulta-content-btn").append("<img src='/assets/img/load.gif' id='load' style='margin: 0px;max-width: 25px;'>");
        },
        complete: function () {
            $("#load").remove();
            $("#consulta-content-btn a").before(btn);
        },
        success: function (data) {
            var html = '';
            $.each(data, function (index, value) {
                html += value;
            });
            $("#consulta-content").empty();
            $("#consulta-content").append(html);
            $("#btn-modal").trigger('click');
        },
        error: function (data) {
            $.each(data.responseJSON, function (index, value) {
                if (data.responseJSON.messages) {
                    alertRequests('danger', data.responseJSON.messages, 'alert-consulta');
                } else {
                    $("#" + index).css({"background-color": "rgb(242, 222, 222)"});
                    alertRequests('danger', 'Informe o CNPJ', 'alert-consulta');
                }
            });
        }
    });
}

function salvarConsulta() {

    var formData = new FormData();

    formData.append('cnpj', cnpj);
    formData.append('_token', token);

    var btn = $('#salvar-consulta').clone();

    $.ajax({
        type: "POST",
        url: "/app/sintegra/store",
        data: formData,
        contentType: false,
        cache: false,
        processData: false, beforeSend: function () {
            $('#salvar-consulta').remove();
            $("#consulta-modal").append("<img src='/assets/img/load.gif' id='load' style='margin: 0px;max-width: 25px;'>");
        },
        complete: function () {
            $("#load").remove();
            $("#consulta-modal button").before(btn);
        },

        success: function (data) {
            alertRequests('success', 'Consulta salva com sucesso', 'alert-consulta');
            $("#sair").trigger('click');
            $("#retornanr").removeAttr('style');
        },
        error: function (data) {
            alertRequests('danger', data.responseJSON.messages, 'alert-consulta');
            $("#sair").trigger('click');
        }
    });
}
function deleteRow(id) {
    if(id) {
        $.ajax({
            type: "GET",
            url: "/app/sintegra/delete/" + id,
            cache: false,
            success: function (data) {
                location.reload();
            }
        });
    }
}

function viewDetails(id) {
    if(id) {
        $.ajax({
            type: "GET",
            url: "/app/sintegra/get/" + id,
            cache: false,
            success: function (data) {
                var obj = jQuery.parseJSON(data.resultado_json);
                var html = '' +
                    '<div class="row">' +
                        '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> Data cadastral: ' +
                            obj.dados_gerais.data_cadastro+
                        '</div>' +
                        '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> CNPJ: ' +
                            obj.dados_gerais.cnpj+
                        '</div>' +
                    '</div>' +
                    '<div class="row">' +
                        '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> Inscrição Estadual: ' +
                            obj.dados_gerais.inscricao_estadual+
                        '</div>' +
                        '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> Razão Social: ' +
                            obj.dados_gerais.razao_social+
                        '</div>' +
                    '</div>' +
                    '<div class="row">' +
                        '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> Rua: ' +
                            obj.endereco.logradouro+
                        '</div>' +
                        '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> Bairro: ' +
                            obj.endereco.bairro+
                        '</div>' +
                    '</div>' +
                    '<div class="row">' +
                        '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> Número: ' +
                            obj.endereco.numero+
                        '</div>' +
                        '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> CEP: ' +
                            obj.endereco.cep+
                        '</div>' +
                    '</div>' +
                    '<div class="row">' +
                        '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> Município: ' +
                            obj.endereco.municipio+
                        '</div>' +
                        '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> UF: ' +
                            obj.endereco.uf+
                        '</div>' +
                    '</div>';

                $("#consulta-content").empty();
                $("#consulta-content").append(html);
                $("#btn-modal").trigger('click');
            }
        });
    }
}
function alertRequests(type, data, id) {
    $("#" + id).empty();
    $("#" + id).append('<div class="alert alert-' + type + '" role="alert">' + data + '</div>');
}

