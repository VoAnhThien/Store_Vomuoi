<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('auth.login');
    }

    /**
     * Đăng nhập bằng Phone/Email + Password
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string', // Phone hoặc Email
            'password' => 'required|min:6',
        ], [
            'login.required' => 'Vui lòng nhập số điện thoại hoặc email',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        $loginField = $request->input('login');
        $loginType = filter_var($loginField, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials = [
            $loginType => $loginField,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }

            return redirect()->intended(route('homepage'));
        }

        return back()->withErrors([
            'login' => 'Số điện thoại/Email hoặc mật khẩu không chính xác.',
        ])->withInput($request->only('login'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('homepage')->with('success', 'Đã đăng xuất thành công!');
    }
}
