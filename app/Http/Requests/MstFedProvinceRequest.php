<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class MstFedProvinceRequest extends FormRequest
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
            'code'=>'max:20',
            'name_lc'=>'required|max:200|unique:mst_fed_province,name_lc'.$id_check,
            'name_en'=>'required|max:200|unique:mst_fed_province,name_en'.$id_check,
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
            'name_en.unique'=> trans('validationMessage.name_en'),
            'name_lc.unique'=>trans('validationMessage.name_lc'),
            'name_lc.required'=>'प्रदेशको नाम आवश्यक छ',
            'name_en.required'=>'प्रदेशको Name आवश्यक छ',
        ];
    }
}
