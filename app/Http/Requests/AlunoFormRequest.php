<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlunoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'situacao' => 'required',
            'curso' => 'required',
            'turma' => 'required',
            'cep' => 'required',
            'numero' => 'required',
            'data_matricula' => 'required',
            'foto' => 'image'
        ];
    }
    
    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',            
            'image' => 'Arquivo não é uma imagem válida'
        ];
    }
}
