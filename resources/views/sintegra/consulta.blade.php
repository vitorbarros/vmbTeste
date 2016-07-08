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
                            <form id="loginForm" method="POST" onsubmit="event.preventDefault();consulta()">
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
@endsection