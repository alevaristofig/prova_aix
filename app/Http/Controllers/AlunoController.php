<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Image;
use App\Aluno;
use App\Curso;
use App\AlunoCurso;
use App\Http\Requests\AlunoFormRequest;
use DB;

class AlunoController extends Controller
{
    private $aluno;    
    private $curso;    
    private $alunoCurso;
    
    public function __construct(Aluno $aluno,Curso $curso,AlunoCurso $alunoCurso)
    {
        $this->aluno = $aluno;
        $this->curso = $curso;
        $this->alunoCurso = $alunoCurso;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('aluno');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cursos = $this->curso::all();
      
        return view('form_aluno', compact('cursos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AlunoFormRequest $request)
    {
        $data = $request->all();
        $data['foto'] = $request->file('foto')->getClientOriginalName();
     
        $foto = $request->file('foto')->store('fotos','public');
        
        $img = Image::make('storage/'.$foto);
        
        $img->resize(45, 47, function ($constraint) {
            $constraint->aspectRatio();
        })->save('storage/'.$foto);
        
        $img->destroy();
        
        $data['foto_arquivo'] = $foto;   
       
        $alunos = $this->aluno->create($data);
       
        $alunos->alunoCurso()->attach($data['curso'],['turma' => $data['turma'], 'data_matricula' => $data['data_matricula']]);
        
        flash('Aluno Cadastrado com Sucesso!')->success();
        
        return redirect()->route('matricula.aluno.store');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cursos = $this->curso::all();
        $aluno = $this->aluno::select('alunos.*','aluno_curso.id AS id_aluno_curso','aluno_curso.curso_id AS curso','aluno_curso.data_matricula','aluno_curso.turma')
                            ->join('aluno_curso','aluno_curso.aluno_id','=','alunos.id')
                            ->join('cursos','cursos.id','=','aluno_curso.curso_id')
                            ->where('alunos.id','=',$id)                           
                            ->get();
        
        if(sizeof($aluno) > 0)
        {
            return view('form_aluno_edit',compact('aluno','cursos'));
        }
        else
        {
            flash('Os dados do Aluno não foram encontrados!')->warning();
        
            return redirect('matricula/aluno');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AlunoFormRequest $request, $id)
    {        
        $aluno = $this->aluno->find($id);     
 
        $alunoCurso = $this->alunoCurso->find($request->input('id_aluno_curso'));      
        
        $aluno->foto = $request->input('foto_antiga');
        $aluno->foto_arquivo = $request->input('foto_arquivo_antigo');
              
        if($request->hasFile('foto'))
        {
            $aluno->foto = $request->file('foto')->store('fotos','public');   
            unlink('storage/'.$request->input('foto_arquivo_antigo'));
            
            $img = Image::make('storage/'.$aluno->foto);
        
            $img->resize(45, 47, function ($constraint) {
                $constraint->aspectRatio();
            })->save('storage/'.$aluno->foto);

            $img->destroy();

            $aluno->foto_arquivo = $aluno->foto;   
       
        }
        
        $aluno->nome = $request->input('nome');
        $aluno->situacao = $request->input('situacao');
        $aluno->logradouro = $request->input('logradouro');
        $aluno->bairro = $request->input('bairro');
        $aluno->numero = $request->input('numero');
        $aluno->complemento = $request->input('complemento');
        $aluno->cidade = $request->input('cidade');
        $aluno->estado = $request->input('estado');
        $aluno->cep = $request->input('cep');
        $alunoCurso->curso_id = $request->input('curso');
        $alunoCurso->turma = $request->input('turma');
        $alunoCurso->data_matricula = $request->input('data_matricula');
        
        $aluno->update();
        $alunoCurso->update();
      
        flash('Aluno atualizado com Sucesso!')->success();

        return redirect('matricula/aluno');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $aluno = $this->aluno::find($id);
        $aluno->alunoCurso()->detach();
        
        $aluno->delete();
        
        flash('Aluno removido com Sucesso!')->success();

        return redirect('matricula/aluno');
    }
    
    //metodo que busca a lista de alunos no banco de dados
    public function listarAluno(Request $request)
    {
        $query = $request->get('search');
        
        if($query['value'] == null)
         {
              $aluno = Aluno::latest()->get();       
         }
         else
         { 
            $aluno = Aluno::where('id','LIKE', '%'.$query['value'].'%')->get();            
         }        
  
        return Datatables::of($aluno)
                ->addColumn('acoes',function($aluno){
                    $button = '<a name="editar" '
                            . 'href="/matricula/aluno/'.$aluno->id.'/edit" class="btn btn-primary btn-sm" style="margin-right:10px;float:left;">Editar</a>';
                    $button.= '<form action="'.route('matricula.aluno.destroy',['aluno' => $aluno->id]).'" method="post" style="float:left;">';
                    $button.= '<input type="hidden" name="_token" value="'.csrf_token().'">';
                    $button.= '<input type="hidden" name="_method" value="DELETE">';
                    $button.= '<button type="submit" class="btn btn-sm btn-danger">APAGAR</button>';
                    $button.= '</form>';
                  
                    return $button;
                })
                ->rawColumns(['acoes'])
                ->make(true);
    }
}
