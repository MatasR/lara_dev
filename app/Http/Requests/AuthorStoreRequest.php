<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class AuthorStoreRequest extends FormRequest
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
                    'name'  => 'required|min:6|unique:authors,name'
                ];
            }
            case 'PUT':
            case 'PATCH':{
                return [
                    'name' => 'required|min:6|unique:authors,name,'.$request->get('id')
                ];
            }
        }
    }
}
