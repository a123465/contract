<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Request $request)
    {
        $user = $request->user();
        return view('profile.show', ['user' => $user]);
    }

    public function edit(Request $request)
    {
        $user = $request->user();
        return view('profile.edit', ['user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $rules = [
              'nickname' => ['nullable','regex:/^[\p{Han}A-Za-z0-9]{4,20}$/u'],
            'bio' => ['nullable','string','max:2000'],
            'birthday' => ['nullable','date'],
            'gender' => ['nullable','string','max:16'],
            'occupation' => ['nullable','string','max:120'],
            'hometown' => ['nullable','string','max:120'],
            'avatar' => ['nullable','image','max:2048'],
        ];

        $messages = [
              'nickname.regex' => '昵称仅支持中文、字母或数字，长度为 4-20 个字符。',
        ];

        $data = $request->validate($rules, $messages);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        $user->fill($data);
        $user->save();

        return redirect()->route('profile')->with('success','资料已更新');
    }

    public function security(Request $request)
    {
        $user = $request->user();
        // get recent sessions (from sessions table if available)
        $records = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity','desc')
            ->limit(20)
            ->get();

        return view('profile.security', ['user' => $user, 'records' => $records]);
    }

    public function updatePassword(Request $request)
    {
        $user = $request->user();
        $rules = [
            'current_password' => ['required'],
            'password' => [
                'required',
                'string',
                'confirmed',
                // allow special chars but require at least one letter and one digit, length 8-16
                'regex:/^(?=.*[A-Za-z])(?=.*\d).{8,16}$/'
            ],
        ];

        $messages = [
            'password.regex' => '密码必须为 8-16 位，且至少包含一个字母和一个数字。',
            'current_password.required' => '请输入当前密码。',
        ];

        $data = $request->validate($rules, $messages);

        if (! Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => '当前密码不正确']);
        }

        $user->password = $data['password'];
        $user->save();

        return back()->with('success','密码已更新');
    }

    public function bindPhone(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'phone' => ['required','string','max:30'],
        ]);

        $user->phone = $data['phone'];
        $user->save();

        return back()->with('success','手机号已绑定');
    }
}
