<?php namespace App\Http\Requests;
use App\Http\Requests\Request;
use Input;

class AddressReceiveRequest extends Request{

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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'name'  => 'required',
                    'email' => 'required|email',
                    'phone' => 'required',
                    'street' => 'required',
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'name.required'     => 'Vui lòng nhập tên',
            'email.required'    => 'Vui lòng nhập email',
            'phone.required'    => 'Vui lòng nhập điện thoại',
            'street.required'   => 'Vui lòng nhập địa chỉ',
        ];
    }
}
