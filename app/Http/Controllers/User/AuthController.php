<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Mail\ResetMail;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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
        $login = $request->input('login');
        $password = $request->input('password');

        // Email ile giriş yapma denemesi
        // E-posta veya telefon numarası olduğunu kontrol et
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            // Email ile giriş yapma denemesi
            $credentials = ['email' => $login, 'password' => $password];
        } else {
            // Telefon numarası ile giriş yapma denemesi
            $credentials = ['phone' => $login, 'password' => $password];
        }

        if (Auth::guard('user')->attempt($credentials)) {
            return redirect()->route('user.home')->with('message', 'Giriş Başarılı.');
        } else {
            return redirect()->route('front.login')->with('loginError', 'Hatalı E-Posta/Telefon veya Şifre girdiniz. Bilgileri kontrol ederek tekrar deneyiniz!');
        }

    }

    public function logout()
    {
        auth()->guard("user")->logout();
        return redirect()->route('front.home')->with('error', 'Çıkış Başarılı.');
    }

    public function register(UserRegisterRequest $request)
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

        $model = new User();
        $model->fill($request->all())->save();

        return redirect()->route('front.login')->with('message', 'Giriş Başarılı.');
    }

    public function forgotPasswordGet()
    {
        return view('user.pages.forgotPassword');
    }

    public function forgotPassword(Request $request)
    {
        $user = User::query()->where("email", $request->email)->first();

        if ($user) {

            $renewCode = Hash::make(now()->format("Y-m-d H:i:s"));

            $renewLink = config("app.url") . '/kullanici/sifre-yenileme?reset_token=' . $renewCode;

            $data = [
                "site_url" => config("app.url"),
                "mail_title" => "Şifre Yenileme Bağlantısı",
                "mail_content" => "Şifre yenileme isteğiniz alındı. Aşağıdaki Butona tıklayarak şifrenizi yenileyebilirsiniz.",
                "renew_link" => $renewLink,
            ];

            $address = $request->email;
            $subject = "Şifre Yenileme Bağlantısı";


            Mail::to($address)->send(new ResetMail($data, $address, $subject));

            $datetime = Carbon::now()->format("Y-m-d H:i:s");
            PasswordReset::where("email", $request->email)->delete();

            $passwordReset = new PasswordReset();

            $passwordReset->insert([
                "email" => $request->email,
                "token" => $renewCode,
                "created_at" => $datetime
            ]);

            return redirect()->route('front.login')->with('success', 'Mail Gönderildi. Biraz uzun sürebilir bekleyiniz.');


        } else {
            return redirect()->route('front.home')->with('error', 'Kullanıcı Bulunamadı.');
        }
    }

    public function resetPasswordGet(Request $request)
    {
        $reset_token = $request->query('reset_token');
        return view('user.pages.resetPassword', compact("reset_token"));
    }

    public function resetPassword(Request $request)
    {
        if (($request->has("reset_token"))) {

            $request->validate([
                'password' => 'required|confirmed',
            ]);
            $renewCode = PasswordReset::where("token", $request->reset_token)->first();

            $user = User::where("email", $renewCode->email)->first();

            $user->password = Hash::make($request->password);
            $result = $user->save();

            PasswordReset::where("email", $user->email)->delete();

            if ($result) {
                return redirect()->route('front.login')->with('success', 'Şifre Başarıyla Değiştirilmiştir.');
            } else {
                return redirect()->back()->with('error', 'Hatalı İşlem.');
            }
        } else {
            return redirect()->route('front.home')->with('error', 'Hatalı Url.');
        }
    }
}
