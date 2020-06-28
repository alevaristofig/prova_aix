<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlunoCurso extends Model
{
    protected $table = 'aluno_curso';
    protected $primaryKey = 'id';
    
    public $timestamp = false;
    
    protected $fillable = ['aluno_id','curso_id','turma','data_matricula','created_at','updated_at'];
    
    public function alunos()
    {        
        return $this->belongsToMany(Aluno::class,'aluno_id','curso_id');
    }
}
