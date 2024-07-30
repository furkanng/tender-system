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
        $brand = $request->input('brand');
        $dateSort = $request->input('date_sort', 'desc'); // Default to 'desc' if not specified
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
                });
        } else {
            $query->where('closed_date', '>=', $now);
        }

        if ($brand) {
            $query->where('brand', $brand);
        }

        if ($dateSort) {
            $query->orderBy('created_at', $dateSort);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $tenders = $query->paginate(20);
        $tenders->appends($request->all());

        // Available brands to filter
        $brands = Tender::query()
            ->select('brand')
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->where('brand', '!=', '-')
            ->distinct()
            ->orderBy('brand')
            ->pluck('brand');
        return view('user.pages.ihale', compact('tenders', 'brands'));
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
