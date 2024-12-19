<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\admin\store;
use App\Http\Requests\admin\login;

class AuthController extends Controller
{
    public function register(store $request)
    {

        $validatedDate = $request->validated();
        $admin = Admin::create([
            'name' => $validatedDate['name'],
            'email' => $validatedDate['email'],
            'password' => Hash::make($validatedDate['password']),
        ]);
        return response()->json([
            'message' => 'admin registration successful',
            'admin' => $admin,
        ], 201);
    }
    public function loadLoginPage()
    {
        return view('Admin.login');
    }

    public function loginUser(login $request)
    {
        $credentials = $request->validated();
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard')->with('success', 'تم تسجيل الدخول بنجاح');
        }

        return back()->withErrors(['error' => 'بيانات غير صحيحة'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('loginPage')->with('success', 'تم تسجيل الخروج بنجاح');
    }
}
