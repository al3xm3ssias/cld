<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'hora_fim' => 'required',
            'hora_inicio' => 'required',
            'data' => 'required',
            'solicitante_id' => 'required',
            'laboratorio_id' => 'required',
            'usuario_id' => 'required'
        ];
    }
}
