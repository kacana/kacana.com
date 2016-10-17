<?php namespace App\Http\Requests;
use App\Http\Requests\Request;

class CartRequest extends Request{

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
                    'name_2'    => 'required',
                    'phone_2'   => 'required',
                    'street'    => 'required|min:5',
                    'city_id'   => 'required',
                    'ward_id'   => 'required',

                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            'name.required'         => 'Vui lòng nhập họ và tên',
            'email.required'        => 'Vui lòng nhập email',
            'phone.required'        => 'Vui lòng nhập điện thoại',
            'name_2.required'       => 'Vui lòng nhập họ và tên người nhận',
            'phone_2.required'      => 'Vui lòng nhập điện thoại người nhận',
            'street.required'       => 'Vui lòng nhập địa chỉ giao hàng',
            'city_id.required'      => 'Vui lòng chọn thành phố',
            'city_id.required'      => 'Vui lòng chọn quận'
        ];
    }
}
