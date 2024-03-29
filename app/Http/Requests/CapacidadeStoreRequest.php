<?php

namespace App\Http\Requests;

use App\Models\Uasignada;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Maatwebsite\Excel\Concerns\ToArray;

class CapacidadeStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !capacidad_cerrado($this->request->get('uasignada_id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $uasignada = Uasignada::findOrFail($this->request->get('uasignada_id'));
        return [
            //
            'fecha'=>'before_or_equal:'.$uasignada->periodo->ffin,
        ];
    }
}
