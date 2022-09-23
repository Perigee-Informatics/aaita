<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class MstFiscalYearRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id_check = $this->request->get('id') ? ",".$this->request->get('id') : "";
        return [
            'code' => 'max:20|unique:mst_fiscal_year,code'.$id_check,
            'from_date_bs' => 'required|max:10|unique:mst_fiscal_year,from_date_bs'.$id_check,
            'to_date_bs' => 'required|max:10',
            'from_date_ad' => 'required|max:10|unique:mst_fiscal_year,from_date_ad'.$id_check,
            'to_date_ad' => 'required|max:10',
            'remarks' => 'max:500',

        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
