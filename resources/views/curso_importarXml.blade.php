@extends('layouts.app')

@section('titulo','Cursos')

@section('content')
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h3>Importar Xml Curso</h3>               
        <form action="/curso/importar" method="post" enctype="multipart/form-data">
            @csrf              
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="logomarca">Arquivo xml</label>                
                        <div class="flt" id="img_logo_empresa"></div>                                                    
                        <input type="file" id="xml" name="xml" class="file @error('xml') is-invalid @enderror" multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Selecione o Arquivo...">                                       
                        @error('xml')
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

