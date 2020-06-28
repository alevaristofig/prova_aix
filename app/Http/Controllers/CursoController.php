<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables; 
use App\Curso;
use App\Http\Requests\CursoFormRequest;
use DB;

class CursoController extends Controller
{
    private $curso;
    
    public function __construct(Curso $curso) 
    {
        $this->curso = $curso;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('curso');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $curso = Curso::find($id);
        
        return view('form_curso_edit',compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CursoFormRequest $request, $id)
    {
        $curso = Curso::find($id);

        $curso->nome = $request->input('nome');
        $curso->codigo = $request->input('codigo');

        $curso->update();

        flash('Curso alterado com Sucesso!')->success();

        return redirect('matricula/curso');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $curso = Curso::find($id);               
        
        $curso->alunoCurso()->detach();
        
        $curso->delete();
        
        flash('Curso removido com Sucesso!')->success();

        return redirect('matricula/curso');
    }
    
    //metodo que manda para a view de importação do arquivo xml
    public function importarXml()
    {
        return view('curso_importarXml');
    }
    
    //metodo que le o arquivo xml e grava os dados no banco de dados
    public function importar(Request $request)
    {       
        if($request->file('xml') != null)
        {        
            
            if($request->file('xml')->getMimeType() == 'text/xml')
            {                
                $xml_arquivo = $request->file('xml')->store('xml','public');

                $xml = simplexml_load_file('storage/'.$xml_arquivo);

                if($xml)
                {
                    foreach($xml as $item)
                    {
                        $this->curso = new Curso();
                        $this->curso->codigo = $item->codigo;
                        $this->curso->nome = $item->nome;

                        $this->curso->save();
                    }

                    flash('Arquivo importado com Sucesso!')->success();
                }
                else
                {
                    flash('Ocorreu um erro e o arquivo não foi importado!')->error();
                }
            }
            else
            {
                flash('Ocorreu um erro e o arquivo não foi importado!')->error();
            }
        }
        else
        {
            flash('Ocorreu um erro e o arquivo não foi importado!')->error();
        }
                        
        return redirect('curso/importarxml');
    }
    
    //metodo que busca a lista de cursos no banco de dados
    public function listarCursos(Request $request)
    {        
        $query = $request->get('search');
      
         if($query['value'] == null)
         {
              $curso = Curso::latest()->get();             
         }
         else
         { 
            $curso = Curso::where('codigo','LIKE', '%'.$query['value'].'%')->get();            
         }

        return Datatables::of($curso)              
                ->addColumn('acoes',function($curso){
                    $button = '<a name="editar" '
                            . 'href="/matricula/curso/'.$curso->id.'/edit" class="btn btn-primary btn-sm" style="margin-right:10px;float:left;">Editar</a>';
                    
                    //$button.= '<form action="/matricula/curso/destroy/'.$curso->id.'" method="post">';
                    $button.= '<form action="'.route('matricula.curso.destroy',['curso' => $curso->id]).'" method="post" styel="flato:left;">';
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
