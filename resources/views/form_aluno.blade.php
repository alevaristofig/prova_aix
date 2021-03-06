@extends('layouts.app')

@section('titulo','Alunos')

@section('content')
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <h3>Novo Aluno</h3>               
        <form action="{{route('matricula.aluno.store')}}" method="post" enctype="multipart/form-data">
            @csrf              
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="logomarca">Foto</label>                
                        <div class="flt" id="img_logo_empresa"></div>                                                    
                        <input type="file"  id="foto" name="foto" class="file @error('foto.*') is-invalid @enderror" multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Selecione a Foto...">                                       
                        @error('foto')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>            
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" name="nome" class="form-control @error('nome') is-invalid @enderror" value="{{old('nome')}}" placeholder="Nome...">
                        @error('nome')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>            
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="situacao">Situação</label>
                        <input type="text" name="situacao" id="situacao" class="form-control @error('situacao') is-invalid @enderror" value="{{old('situacao')}}" placeholder="Situação...">
                        @error('situacao')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>            
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="situacao">Curso</label>
                        <select id="curso" name="curso" class="form-control @error('curso') is-invalid @enderror">
                            <option value="">Escolha um curso</option>
                            @foreach($cursos AS $curso)
                                <option value="{{$curso->id}}">{{$curso->nome}}</option>
                            @endforeach                            
                        </select>
                        @error('curso')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>            
                        @enderror
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="turma">Turma</label>
                        <input type="text" name="turma" id="turma" class="form-control @error('turma') is-invalid @enderror" value="{{old('turma')}}" placeholder="Turma...">
                        @error('turma')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>            
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="cep">Cep</label>
                        <input type="text" name="cep" id="cep" class="form-control @error('cep') is-invalid @enderror" value="{{old('cep')}}" placeholder="Cep...">
                         @error('cep')
                            <div class="invalid-feedback">
                                {{$message}}
                            </div>            
                        @enderror
                    </div>    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="logradouro">Logradouro</label>
                        <input type="text" name="logradouro" id="logradouro" class="form-control" readonly placeholder="Logradouro...">
                    </div>    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="numero">Número</label>
                        <input type="text" name="numero" id="numero" class="form-control" placeholder="Número...">
                    </div>    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                   <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" name="complemento" id="complemento" class="form-control" placeholder="Complemento...">
                    </div>    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="bairro">Bairro</label>
                        <input type="text" name="bairro" id="bairro" class="form-control" readonly placeholder="Bairro...">
                    </div>    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="cidade">Cidade</label>
                        <input type="text" name="cidade" id="cidade" class="form-control" readonly placeholder="Cidade...">
                    </div>    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" name="estado" id="estado" class="form-control" readonly placeholder="Estado...">
                    </div>    
                </div>                
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label for="data_matricula">Data da Matrícula</label>
                        <input type="date" name="data_matricula" id="data_matricula" class="form-control @error('data_matricula') is-invalid @enderror" value="{{old('data_matricula')}}" placeholder="Data Matrícula...">
                        @error('data_matricula')
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
