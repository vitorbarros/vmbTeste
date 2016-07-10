$(document).ready(function(){
    //configuração do menu lateral Client
    var urlApp = window.location.pathname;
    var reApp = /sintegra/g;
    var mApp;

    while ((mApp = reApp.exec(urlApp)) !== null){
        $("#" + mApp).attr('class','active');
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
            if(!data.responseJSON.messages) {
                $.each(data.responseJSON, function(index, value) {
                    $("#" + index).css({"background-color":"rgb(242, 222, 222)"});
                });
                alertRequests('danger', 'Preencha os campos em vermelho', 'alert-login');
            }else{
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

    $.ajax({
        type: "POST",
        url: "/app/sintegra/sintegra-request",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            var html = '';
            $.each(data, function (index, value){
                html += value;
            });
            $("#consulta-content").empty();
            $("#consulta-content").append(html);
            $("#btn-modal").trigger('click');
        },
        error: function (data) {
            $.each(data.responseJSON, function(index, value) {
                $("#" + index).css({"background-color":"rgb(242, 222, 222)"});
            });
            alertRequests('danger', 'Informe o CNPJ', 'alert-consulta');
        }
    });
}

function salvarConsulta() {

    var formData = new FormData();
    
    formData.append('cnpj', cnpj);
    formData.append('_token', token);

    $.ajax({
        type: "POST",
        url: "/app/sintegra/store",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {},
        error: function (data) {}
    });
}
function alertRequests(type, data, id) {
    $("#" + id).empty();
    $("#" + id).append('<div class="alert alert-' + type + '" role="alert">' + data + '</div>');
}