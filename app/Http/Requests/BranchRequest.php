<?php namespace App\Http\Requests;
use App\Http\Requests\Request;

class BranchRequest extends Request{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required|min:2',
            //'image' => 'mimes:jpeg,bmp,png'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên thương hiệu'
        ];
    }
}