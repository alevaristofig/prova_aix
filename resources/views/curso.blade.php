@extends('layouts.app')

@section('titulo','Cursos')
@section('content')
    <div class="row">        
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <div class="table-responsive">
                <table id="curso_lista" class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>Código</th>
                            <th>Nome</th>                            
                            <th>Ações</th>
                        </tr>
                    </thead>
                </table>            
            </div>
        </div>
    </div>
@endsection

