@extends('layouts.app')

@section('titulo','Cursos')

@section('content')
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">                 
        <form action="{{route('matricula.curso.update',['curso' => $curso->id])}}" method="post" enctype="multipart/form-data">
            @csrf        
            @method("PUT")
            <div class="row">                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{$curso->nome}}" placeholder="Nome...">
                        @error('nome')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>            
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="situacao">Código</label>
                        <input type="text" name="codigo" id="codigo" class="form-control @error('codigo') is-invalid @enderror" value="{{$curso->codigo}}" placeholder="Código...">
                        @error('codigo')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>            
                        @enderror
                    </div>
                </div>                                           
            </div>
            
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Salvar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </form>
        
    </div>
</div>
@endsection


