<?php namespace App\Http\Requests;
use App\Http\Requests\Request;

class ProductRequest extends Request{

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
                return[];
            }
            case 'POST':
            case 'PUT':
            {
                return [
                    'name'      => 'required|min:6|max:255',
                    'image'     => 'mimes:jpeg,bmp,png',
                    'price'     => 'required|numeric',
                    'sell_price'=> 'required|numeric',
                    'tags'      => 'required',
                ];
            }
            default:break;
        }
    }

    /**
     * Show messages
     *
     * @return array
     */
    public function messages(){
        return [
            'name.required'         => 'Vui lòng nhập tên sản phẩm',
            'price.required'        => 'Vui lòng nhập giá sản phẩm',
            'sell_price.required'   => 'Vui lòng nhập giá bán của sản phẩm',
            'tags.required'         => 'Vui lòng chọn tags cho sản phẩm',
            'price.numeric'         => 'Giá phải là số',
            'sell_price.numeric'    => 'Giá bán phải là số'
        ];
    }
}