<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\user\store;
use App\Http\Requests\user\login;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Notifications\VerifyPhone;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(store $request)
    {
        $validatedData = $request->validated();
        $validatedData['password'] = Hash::make($validatedData['password']);
        $user = User::create($validatedData);
    
        $verificationCode = mt_rand(100000, 999999);
        $user->verification_code = $verificationCode;
        $user->save();
    
        $user->notify(new VerifyPhone($verificationCode));
    
        return response()->json([
            'user' => $user,
            'message' => 'تم التسجيل بنجاح. تم إرسال رمز التحقق إلى هاتفك.',
        ], 201);
    }
    
    public function verifyPhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'verification_code' => 'required|numeric',
        ]);
    
        $user = User::where('phone', $request->phone)
                    ->where('verification_code', $request->verification_code)
                    ->first();
    
        if (!$user) {
            return response()->json('رمز التحقق أو رقم الهاتف غير صحيح', 400);
        }
    
        $user->phone_verified = true;
        $user->verification_code = null;
        $user->save();
    
        return response()->json(['message' => 'تم التحقق من الهاتف بنجاح']);
    }
    
    public function login(login $request)
    {
        $validatedData = $request->validated();
        $user = User::where('email', $request->input('email'))->first();
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            return response()->json('بيانات الاعتماد غير صحيحة', 404);
        }
        if ($user->verification_code != null) {
            return response()->json('يرجى التحقق من هاتفك قبل تسجيل الدخول.', 403);
        }
        $token = $user->createToken('Api token of ' . $user->name)->plainTextToken;
    
        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
    
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => Auth::user()->name . '، لقد تم تسجيل خروجك بنجاح وتم حذف الرمز الخاص بك'
        ]);
    }
    
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['email' => 'المستخدم غير موجود'], 404);
        }
    
        $code = mt_rand(100000, 999999);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $code,
                'created_at' => now()
            ]
        );
    
        Mail::raw("رمز إعادة تعيين كلمة المرور الخاص بك هو: $code", function ($message) use ($user) {
            $message->to($user->email)
                ->subject('رمز إعادة تعيين كلمة المرور');
        });
    
        return response()->json(['message' => 'تم إرسال رمز إعادة تعيين كلمة المرور إلى بريدك الإلكتروني']);
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
            'password' => 'required|confirmed',
        ]);
    
        $resetEntry = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->code)
            ->first();
    
        if (!$resetEntry) {
            return response()->json([
                'message' => 'رمز غير صالح',
            ]);
        }
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
    
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        return response()->json([
            'message' => 'تم إعادة تعيين كلمة المرور بنجاح',
        ]);
    }
}
