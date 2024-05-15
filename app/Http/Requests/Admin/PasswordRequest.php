<?php


namespace App\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
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
        $rules =[
            'current_password' => 'required|password',
            'new_password' => 'required|regex:/^[a-zA-Z0-9_\-!@#$%^&*()]+$/|different:current_password',
            'confirm_new_password' => 'required|same:new_password',
        ];
        return $rules;
    }

    public function messages(){
        return [
            'current_password.required' => 'Mật khẩu hiện tại là bắt buộc.',
            'current_password.password' => 'Mật khẩu hiện tại không đúng.',
            'new_password.required' => 'Mật khẩu mới là bắt buộc.',
            'new_password.different' => 'Mật khẩu mới phải khác mật khẩu hiện tại.',
            'new_password.regex' => 'Mật khẩu mới không hợp lệ. Vui lòng chỉ sử dụng chữ cái (a-z, A-Z), chữ số hoặc ký tự đặc biệt.',
            'confirm_new_password.required' => 'Xác nhận mật khẩu mới là bắt buộc.',
            'confirm_new_password.same' => 'Mật khẩu xác nhận phải khớp với mật khẩu mới.',
        ];
    }

    public $validator = null;
    protected function failedValidation($validator)
    {
        $this->validator = $validator;
    }
}
