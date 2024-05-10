<?php namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,Email,' . $this->id,
        ];

        if (empty($this->id)) {
            $rules['password'] = 'required|same:password_confirm';
            $rules['password_confirm'] = 'required';
        } else if (!empty($this->id) && !is_null($this->Password)) {
            $rules['password'] = 'same:password_confirm';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Tên không được để trống!',
            'email.required' => 'Email không được để trống!',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại!',

            'password.required' => 'Mật khẩu không được để trống!',
            'password_confirm.required' => 'Nhập lại mật khẩu không được để trống!',
            'password.same' => 'Mật khẩu không khớp!'
        ];
    }

    public $validator = null;

    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }

}
