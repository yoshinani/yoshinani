<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'ユーザ名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attributeが入力されていません',
            'name.string' => ':attributeが文字列ではありません',
            'name.max' => ':attributeは255文字以下にして下さい',
            'email.required' => ':attributeが入力されていません',
            'email.string' => ':attributeが文字列ではありません',
            'email.email' => ':attributeの形式が正しくありません',
            'email.max' => ':attributeは255文字以下にして下さい',
            'email.unique' => ':attributeは既に登録されています',
            'password.required' => ':attributeが入力されていません',
            'password.string' => ':attributeが文字列ではありません',
            'password.min' => ':attributeは6文字以上にして下さい',
            'password.confirmed' => ':attributeが一致していません',
        ];
    }
}
