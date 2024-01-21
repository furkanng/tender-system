<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Tender;
use Illuminate\Http\Request;

class TenderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter');

        $query = $filter
            ? Tender::where('tender_no', 'LIKE', '%' . $filter . '%')
                ->orWhere('name', 'LIKE', '%' . $filter . '%')
                ->orWhere('brand', 'LIKE', '%' . $filter . '%')
                ->orWhere('model', 'LIKE', '%' . $filter . '%')
                ->orWhere('year', 'LIKE', '%' . $filter . '%')
                ->orWhere('plate', 'LIKE', '%' . $filter . '%')
                ->orWhere('fuel_type', 'LIKE', '%' . $filter . '%')
                ->orWhere('sase_no', 'LIKE', '%' . $filter . '%')
                ->orWhere('servicePhone', 'LIKE', '%' . $filter . '%')
                ->orWhere('city', 'LIKE', '%' . $filter . '%')
                ->orWhere('district', 'LIKE', '%' . $filter . '%')
                ->orderBy("created_at", "DESC")
            : Tender::orderBy("created_at", "DESC");

        $tenders = $query->paginate(20);

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
