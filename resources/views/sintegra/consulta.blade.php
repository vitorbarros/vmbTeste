@extends('layout.internal')
@section('content')
    <div class="container-fluid sintegra">
        <div class="container">
            <div class="container-sintegra">
                <div class="title">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3>Realizar nova consulta</h3>
                        </div>
                    </div>
                </div>
                <div class="form">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <form id="consultaForm" method="POST" onsubmit="event.preventDefault();consulta()">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label for="cnpj">CNPJ</label>
                                    <input type="text" id="cnpj" name="cnpj" class="form-control">
                                </div>
                                <div id="alert-consulta"></div>
                                <div class="form-group">
                                    <input type="submit" value="Consultar" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Consulta realizada com sucesso</h4>
                </div>
                <div class="modal-body">
                    <div id="consulta-content"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sair</button>
                    <button type="button" class="btn btn-primary" onclick="salvarConsulta()">Salvar consulta</button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="display: none" id="btn-modal"></button>
@endsection