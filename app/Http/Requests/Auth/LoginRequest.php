<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
        return [
            'email' => 'required|string|email|max:255|exists:users',
            'password' => 'required|string|min:6',
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => ':attributeが入力されていません',
            'email.string' => ':attributeが文字列ではありません',
            'email.email' => ':attributeの形式が正しくありません',
            'email.max' => ':attributeは255文字以下にして下さい',
            'email.exists' => ':attributeが存在していません',
            'password.required' => ':attributeが入力されていません',
            'password.string' => ':attributeが文字列ではありません',
            'password.min' => ':attributeは6文字以上にして下さい',
        ];
    }
}
