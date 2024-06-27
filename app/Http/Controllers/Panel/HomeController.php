<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Archive;
use App\Models\Tender;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $currentMonthCount = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $lastMonthCount = User::whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        $percentageChange = 0;
        if ($lastMonthCount > 0) {
            $percentageChange = (($currentMonthCount - $lastMonthCount) / $lastMonthCount) * 100;
        }

        $usersCount = User::count();
        $tendersCount = Tender::count();
        $archivesCount = Archive::count();
        $lastFiveTenders = Tender::orderBy('id', 'desc')->take(5)->get();

        $onlineUsersCount = User::all()->filter(function ($user) {
            return Cache::has('user-is-online-' . $user->id);
        })->count();

        $tendersCompany = Tender::selectRaw('company_id, COUNT(*) as count')
            ->whereIn('company_id', [1, 2, 3, 99])
            ->groupBy('company_id')
            ->pluck('count', 'company_id')
            ->toArray();

        $autogongCount = $tendersCompany[1] ?? 0;
        $otopertCount = $tendersCompany[2] ?? 0;
        $sovtajyeriCount = $tendersCompany[3] ?? 0;
        $otoIhaleSistemiCount = $tendersCompany[99] ?? 0;


        $data = [
            'usersCount' => $usersCount,
            'tendersCount' => $tendersCount,
            'archivesCount' => $archivesCount,
            'lastFiveTenders' => $lastFiveTenders,
            'onlineUsers' => $onlineUsersCount,
            'currentMonthCount' => $currentMonthCount,
            'percentageChange' => $percentageChange,
            'autogongCount' => $autogongCount,
            'otopertCount' => $otopertCount,
            'sovtajyeriCount' => $sovtajyeriCount,
            'otoIhaleSistemiCount' => $otoIhaleSistemiCount,
        ];
        return view('panel.pages.home', $data);
    }

    public function loginGet()
    {
        return view('panel.pages.login');
    }

    public function getChartData()
    {
        $startDate = Carbon::now()->subMonths(5)->startOfMonth(); // Son 6 ayın başlangıç tarihi
        $endDate = Carbon::now()->endOfMonth(); // Bugünün sonu

        $users = User::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Tüm ayları içeren bir dizi oluştur
        $monthlyData = [];
        $period = \Carbon\CarbonPeriod::create($startDate, '1 month', $endDate);
        foreach ($period as $date) {
            $month = $date->format('Y-m');
            $monthlyData[$month] = $users[$month] ?? 0;
        }

        return response()->json(array_values($monthlyData));
    }

    public function getTenderAnalysticData()
    {
        $tenders = Tender::selectRaw('company_id, COUNT(*) as count')
            ->whereIn('company_id', [1, 2, 3, 99])
            ->groupBy('company_id')
            ->pluck('count', 'company_id')
            ->toArray();

        $autogongCount = $tenders[1] ?? 0;
        $otopertCount = $tenders[2] ?? 0;
        $sovtajyeriCount = $tenders[3] ?? 0;
        $otoIhaleSistemiCount = $tenders[99] ?? 0;
        $totalTenders = $autogongCount + $otopertCount + $sovtajyeriCount + $otoIhaleSistemiCount;

        $autogongPercentage = $totalTenders > 0 ? floor(($autogongCount / $totalTenders) * 100) : 0;
        $otopertPercentage = $totalTenders > 0 ? floor(($otopertCount / $totalTenders) * 100) : 0;
        $sovtajyeriPercentage = $totalTenders > 0 ? floor(($sovtajyeriCount / $totalTenders) * 100) : 0;
        $otoIhaleSistemiPercentage = $totalTenders > 0 ? floor(($otoIhaleSistemiCount / $totalTenders) * 100) : 0;

        return response()->json([
            'autogong' => $autogongPercentage,
            'otopert' => $otopertPercentage,
            'sovtajyeri' => $sovtajyeriPercentage,
            'otoIhaleSistemi' => $otoIhaleSistemiPercentage,
        ]);
    }

}
