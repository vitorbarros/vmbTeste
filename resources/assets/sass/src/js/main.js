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
            alertRequests('danger', data, 'alert-login');
        }
    });
}
function alertRequests(type, data, id) {
    $("#" + id).empty();
    $("#" + id).append('<div class="alert alert-' + type + '" role="alert">' + data.responseJSON.messages + '</div>');
}