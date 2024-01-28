<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Tender;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {

        $usersCount = User::count();
        $tendersCount = Tender::count();
        $archivesCount = Archive::count();
        $lastSixTenders = Tender::orderBy('id', 'desc')->take(6)->get();

        $data = [
            'usersCount' => $usersCount,
            'tendersCount' => $tendersCount,
            'archivesCount' => $archivesCount,
            'lastSixTenders' =>$lastSixTenders
        ];
        return view('panel.pages.home',$data);
    }

    public function loginGet()
    {
        return view('panel.pages.login');
    }

}
