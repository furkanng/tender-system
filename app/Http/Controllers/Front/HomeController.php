<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Tender;

class HomeController extends Controller
{
    public function index()
    {
        $lastSixTenders = Tender::orderBy('id', 'desc')->take(6)->get();


        return view('front.pages.home',['lastSixTenders' => $lastSixTenders]);
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

        $contactInfo = Contact::query()->first();
        return view('front.pages.contact',compact('contactInfo'));
    }

}
