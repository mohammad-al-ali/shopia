<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function register(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',              // الاسم مطلوب، نصي، ولا يزيد عن 255 حرف
            'email' => 'required|email|unique:users,email',   // البريد مطلوب، يجب أن يكون بريد صحيح، ويجب أن يكون فريد في جدول المستخدمين
            'password' => 'required|string|min:6|confirmed', // كلمة المرور مطلوبة، نصية، لا تقل عن 6 أحرف، ويجب تأكيدها (أي يجب أن يكون هناك حقل password_confirmation مطابق)
        ]);

        // Create new user in database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),  // تشفير كلمة المرور قبل الحفظ
        ]);

        // Generate token for user for API authentication
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return JSON response with token and user info
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',  // نوع التوكن، عادة يكون Bearer
            'user' => $user,
        ], 201);  // 201 = Created (تم الإنشاء بنجاح)
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid login details'], 401);
        }

        $user = User::where('email', $request->email)->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
    public function logout(Request $request)
    {
        // Deletes the token used in the current request
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
    public function getProfile(Request $request)
    {
        return response()->json([
            'user' => $request->user()
        ]);
    }

}
