<?php namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PermissionRequest extends FormRequest {

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
        $rules = [
            'name' => 'required','min:3', 'max:100',
            'slug' => 'unique:permissions,slug,'.$this->id,
        ];

        return $rules;

    }

    public function messages(){
        return [
            'name.required' => 'Chưa nhập tên!',
            // 'slug.required' => 'Chưa nhập slug!',
            'slug.unique' => 'Slug đã tồn tại',
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
