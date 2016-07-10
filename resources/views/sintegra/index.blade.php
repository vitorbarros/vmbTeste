@extends('layout.internal')
@section('content')
    <div class="container-fluid sintegra">
        <div class="container">
            <div class="container-sintegra">
                <div class="title">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <h3>Histórico de consultas no Sintegra</h3>
                        </div>
                    </div>
                </div>
                <div class="btn-consulta">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <a href="{{ route('app.sintegra.consulta') }}" class="btn btn-default">Nova consulta</a>
                        </div>
                    </div>
                </div>
                <div class="table">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>CNPJ</th>
                                    <th>Usuário</th>
                                    <th>Data da consulta</th>
                                    <th>Ação</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sintegras as $sintegra)
                                    <tr>
                                        <td>{{ $sintegra->id }}</td>
                                        <td>{{ $sintegra->cnpj }}</td>
                                        <td>{{ $sintegra->user->username }}</td>
                                        <td>{{ (new \DateTime($sintegra->created_at))->format('d/m/Y - H:i') }}</td>
                                        <td>
                                            <button class="btn btn-default" type="button" onclick="viewDetails('{{ $sintegra->id }}')">Ver detalhes</button> /
                                            <button class="btn btn-default" type="button" onclick="deleteRow('{{ $sintegra->id }}')">Deletar</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="pagination-content">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            {!! $sintegras->render() !!}
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
                    <h4 class="modal-title">Detalhes</h4>
                </div>
                <div class="modal-body">
                    <div id="consulta-content"></div>
                </div>
                <div class="modal-footer" id="consulta-modal">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="sair">Sair</button>
                </div>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" style="display: none" id="btn-modal"></button>
@endsection