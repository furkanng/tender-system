<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $client = new Client;
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret'   => env("NOCAPTCHA_SECRET"),
                'response' => $request->input('g-recaptcha-response'),
            ],
        ])->getBody()->getContents();

        if (! json_decode($response, true)['success']) {
            return redirect()->route('front.login')->with('loginError', 'recaptcha geçersiz');
        }
        
        $credentials = $request->only('email', 'password');

        if (Auth::guard("admin")->attempt($credentials)) {
            return redirect()->route('panel.home');
        } else {
            return redirect()->route('panel.login.get')->with('loginError', 'Hatalı E-Posta veya Şifre girdiniz. Bilgileri kontrol ederek tekrar deneyiniz!');
        }
    }

    public function logout()
    {
        auth()->guard("admin")->logout();
        return redirect()->route('front.home')->with('error', 'Çıkış Başarılı.');
    }
}
