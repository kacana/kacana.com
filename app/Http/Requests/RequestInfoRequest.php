<?php namespace App\Http\Requests;
use App\Http\Requests\Request;

class RequestInfoRequest extends Request{

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
                    'name'      => 'required',
                    'email'     => 'required|email',
                    'phone'     => 'required',
                    'message'   => 'required|min:20',
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
            'phone.required'    => 'Vui lòng nhập số điện thoại',
            'message.required'  => 'Vui lòng để lại tin nhắn',
            'message.min'       => 'Tin nhắn quá ngắn (ít nhất 20 ký tự)'
        ];
    }
}
