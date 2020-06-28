<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    protected $table = 'cursos';
    protected $primaryKey = 'id';
    
    public $timestamp = false;
    
    protected $fillabel = ['codigo','nome','created_at','updated_at'];
    
    public function alunoCurso()
    {       
        return $this->belongsToMany(AlunoCurso::class,'aluno_curso',null,'aluno_id')->withPivot(['turma','data_matricula']);
    }
}
