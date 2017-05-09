<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
        switch($this->method()){
            case 'GET':
            case 'DELETE':{
                return [];
            }
            case 'POST':{
                return [
                    'name'  => 'required|min:3|unique:books,name',
                    'new_image' => 'required|image|mimes:jpeg'
                ];
            }
            case 'PUT':
            case 'PATCH':{
                return [
                    'name' => 'required|min:3|unique:books,name,'.$request->get('id'),
                    'image' => 'required',
                    'new_image' => 'image|mimes:jpeg'
                ];
            }
        }
    }
}
