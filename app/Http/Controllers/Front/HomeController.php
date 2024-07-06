<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Setting;
use App\Models\Tender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    public function index()
    {
        $model = new Setting();
        $contact = $model->get("contact_settings");
        $general = $model->get("general_settings");
        $lastSixTenders = Tender::orderBy('id', 'desc')
            ->where("company_id", "!=", 99)
            ->whereNotNull("images")
            ->take(6)
            ->get();
        return view('front.pages.home', compact(["lastSixTenders", "contact", "general"]));
    }

    public function login()
    {
        return view('user.pages.login');
    }

    public function register()
    {
        return view('user.pages.register');
    }

    public function about()
    {
        $model = new Setting();
        $contact = $model->get("contact_settings");
        $general = $model->get("general_settings");
        return view('front.pages.about', compact(["contact", "general"]));
    }

    public function contact()
    {
        $model = new Setting();
        $contact = $model->get("contact_settings");
        $general = $model->get("general_settings");
        return view('front.pages.contact', compact(['contact', 'general']));
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'phone' => 'required'
        ]);

        $admin_mail = Admin::first()->email;

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'phone' => $request->phone,
        ];

        Mail::raw(
            "Name: {$data['name']}\nEmail: {$data['email']}\nPhone: {$data['phone']}\n\nMessage:\n{$data['message']}",
            function ($message) use ($data, $admin_mail) {
                $message->to($admin_mail)
                    ->subject($data['subject']);
            }
        );

        return back()->with('message', 'Sonuç Başarılı');
    }

}
