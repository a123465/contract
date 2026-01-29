<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $rules = [
            'username' => [
                'required', 'string', 'unique:users,username',
                // allow special chars but require at least one alphanumeric (letter or digit), length 8-16
                'regex:/^(?=.*[A-Za-z0-9]).{8,16}$/'
            ],
            'password' => [
                'required',
                'string',
                'confirmed',
                // allow special chars but require at least one letter and one digit, length 8-16
                'regex:/^(?=.*[A-Za-z])(?=.*\d).{8,16}$/'
            ],
            'nickname' => ['nullable','regex:/^[\p{Han}A-Za-z0-9]{4,20}$/u'],
        ];

        $messages = [
            'username.regex' => '账号必须为 8-16 位，且至少包含字母或数字，可以包含特殊字符。',
            'password.regex' => '密码必须为 8-16 位，且至少包含一个字母和一个数字。',
            'nickname.regex' => '昵称仅支持中文、字母或数字，长度为 4-20 个字符。',
        ];

        $data = $request->validate($rules, $messages);

        $data['password'] = Hash::make($data['password']);

        $user = User::create([
            'username' => $data['username'],
            'name' => $data['username'],
            'nickname' => $data['nickname'] ?? null,
            'avatar' => null,
            'password' => $data['password'],
        ]);

        auth()->login($user);

        return redirect()->route('home');
    }
}
