<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Tender;

class HomeController extends Controller
{
    public function index()
    {
        $model = new Setting();
        $contact = $model->get("contact_settings");
        $lastSixTenders = Tender::orderBy('id', 'desc')
            ->where("company_id", "!=", 99)
            ->whereNotNull("images")
            ->take(6)
            ->get();
        return view('front.pages.home', compact(["lastSixTenders", "contact"]));
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
        return view('front.pages.about');
    }

    public function contact()
    {
        $model = new Setting();
        $contact = $model->get("contact_settings");
        return view('front.pages.contact', compact('contact'));
    }

}
