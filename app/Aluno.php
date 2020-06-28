<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $table = 'alunos';
    protected $primaryKey = 'id';
    
    public $timestamp = false;
    
    protected $fillable = ['nome','situacao','foto','foto_arquivo','logradouro','bairro','numero','complemento','cidade','estado','cep','created_at','updated_at'];
    
    public function alunoCurso()
    {       
        return $this->belongsToMany(AlunoCurso::class,'aluno_curso',null,'curso_id')->withPivot(['turma','data_matricula']);
    }
}
