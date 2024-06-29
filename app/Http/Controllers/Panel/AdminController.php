<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\ImageTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::guard("admin")->user();
        return view('panel.pages.profile', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if ($request->has("password")) {
            $request->validate([
                "password" => "required|min:8|confirmed",
            ]);
        }
        
        $user = Admin::findOrFail($id);
        $user->fill($request->all())->save();

        return redirect()->back()->with('message', 'İşlem Başarılı.');
    }

    public function destroy($id): RedirectResponse
    {
        $model = Admin::findOrFail($id);

        $image = $model->image;
        if (isset($image)) {
            Storage::delete("admin/" . $model->image);
        }

        $model->image = null;
        $model->save();

        return redirect()->back()->with('message', 'İşlem Başarılı.');
    }

}
