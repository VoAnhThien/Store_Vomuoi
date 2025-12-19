<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GoogleController extends Controller
{
    /**
     * Redirect to Google
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle callback from Google
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Log để debug
            Log::info('Google User Data:', [
                'id' => $googleUser->id,
                'email' => $googleUser->email,
                'name' => $googleUser->name,
            ]);

            // Tìm hoặc tạo user
            $user = User::where('google_id', $googleUser->id)
                        ->orWhere('email', $googleUser->email)
                        ->first();

            if ($user) {
                // User đã tồn tại → Cập nhật thông tin Google
                $user->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'provider' => 'google',
                ]);
            } else {
                // Tạo user mới
                $user = User::create([
                    'fullname' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'phone' => null,
                    'password' => null,
                    'provider' => 'google',
                    'role' => 'customer',
                ]);
            }

            Auth::login($user);

            // Sửa redirect về homepage thay vì user.dashboard
            return redirect()->route('homepage')
                ->with('success', 'Đăng nhập thành công với Google!');

        } catch (\Exception $e) {
            // Log lỗi chi tiết
            Log::error('Google Login Error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('login')
                ->with('error', 'Có lỗi xảy ra khi đăng nhập với Google: ' . $e->getMessage());
        }
    }
}
