@extends('layouts.app')

@section('titulo','Aluno')
@section('content')
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <a href="{{route('matricula.aluno.create')}}" class="left btn_novo"><button class="btn btn-success">Novo</button></a></h3>      
        </div>
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="table-responsive">
                <table id="aluno_lista" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>
                            <th>Situação</th>                            
                            <th>Ações</th>
                        </tr>
                    </thead>
                </table>            
            </div>
        </div>
    </div>
@endsection
