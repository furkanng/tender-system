<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter');
        $now = Carbon::now()->timestamp;

        $query = Tender::query();

        if ($filter) {
            $query->where('closed_date', '>', $now)
                ->where(function ($q) use ($filter) {
                    $q->where('tender_no', 'LIKE', '%' . $filter . '%')
                        ->orWhere('name', 'LIKE', '%' . $filter . '%')
                        ->orWhere('brand', 'LIKE', '%' . $filter . '%')
                        ->orWhere('model', 'LIKE', '%' . $filter . '%')
                        ->orWhere('year', 'LIKE', '%' . $filter . '%')
                        ->orWhere('plate', 'LIKE', '%' . $filter . '%')
                        ->orWhere('city', 'LIKE', '%' . $filter . '%')
                        ->orWhere('district', 'LIKE', '%' . $filter . '%');
                })
                ->orderBy("created_at", "DESC");
        } else {
            $query->where('closed_date', '>=', $now)->orderBy("created_at", "DESC");
        }

        $tenders = $query->paginate(20);
        $tenders->appends(['filter' => $filter]);

        return view('user.pages.ihale', compact('tenders'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tender = Tender::findOrFail($id);
        return view('user.pages.ihaleShow', compact("tender"));
    }

}
