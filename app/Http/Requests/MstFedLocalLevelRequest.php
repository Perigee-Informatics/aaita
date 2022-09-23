<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class MstFedLocalLevelRequest extends FormRequest
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
            'code' => 'max:20|unique:mst_fed_local_level,code'.$id_check,
            'name_en' => 'required|max:200|unique:mst_fed_local_level,name_en'.$id_check,
            'name_lc' => 'required|max:200|unique:mst_fed_local_level,name_lc'.$id_check,
            'district_id' => 'required',
            'level_type_id' => 'required',
            'remarks' => 'max:500',
            'gps_lat' => 'max:20',
            'gps_long' => 'max:20',
            
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
