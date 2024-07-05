<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Bid;
use App\Models\Tender;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $tendersCount = Tender::count();

        $user = auth()->guard("user")->user();

        $bids = Bid::where('user_id', $user->id)->get();

        $archivesCount = 0;
        $bidsCount = $bids->count() ?? 0;

        $now = Carbon::now()->timestamp;

        $lastFiveTenders = Tender::where('closed_date', '>', $now)->orderBy('created_at', 'desc')->take(5)->get();

        foreach ($bids as $bid) {
            if ($bid->tender){
                $archivesCount = Archive::where("tender_no", $bid->tender->tender_no)->count();
            }
        }

        return view('user.pages.home',
            compact(['tendersCount', 'archivesCount', 'bidsCount', 'lastFiveTenders']));
    }
}
