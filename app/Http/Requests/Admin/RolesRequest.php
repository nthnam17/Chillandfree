<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RolesRequest extends FormRequest {

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
    public function rules()
    {
        return [
            'name' => 'required|min:3|max:50|unique:roles,name,'.$this->id

        ];
    }

    public function messages(){
        return [
            'name.required'        => 'Tên không được để trống!',
            'name.unique'          => 'Tên đã tồn tại!',
            'name.min'             => 'Tên phải có độ dài ít nhất 3 ký tự!',
            'name.max'             => 'Tên phải có độ dài không vượt quá 50 ký tự!',
        ];
    }

    public $validator = null;
    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }

}
