<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard("user")->attempt($credentials)) {
            return redirect()->route('user.home');
        } else {
            return redirect()->route('front.login')->with('error', 'Giriş başarısız.');
        }
    }

    public function logout()
    {
        auth()->guard("user")->logout();
        return redirect()->route('front.home')->with('error', 'Çıkış Başarılı.');
    }

    public function register(UserRegisterRequest $request)
    {
        $model = new User();
        $model->fill($request->all())->save();

        return redirect()->route('front.login')->with('success', 'Giriş Başarılı.');
    }

}
