@extends('layout.layout')
@section('content')
    <div class="container">
        <div class="container-form">
            <div class="title">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h3>Login</h3>
                    </div>
                </div>
            </div>
            <div class="form">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <form id="loginForm" method="POST" onsubmit="event.preventDefault();auth()">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="username">Usuário</label>
                                <input type="text" id="username" name="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">Senha</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div id="alert-login"></div>
                            <div class="form-group">
                                <input type="submit" value="Login" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection