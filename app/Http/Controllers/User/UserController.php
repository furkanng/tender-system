<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->guard("user")->user();
        return view("user.pages.profile", compact("user"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        if ($request->has("password") && $request->get("password") != null) {
            $request->validate([
                "password" => "required|min:8|confirmed",
            ]);
            $user->fill($request->all())->save();

            return redirect()->back()->with('message', 'İşlem Başarılı.');
        }

        $user->fill($request->except("password"))->save();

        return redirect()->back()->with('message', 'İşlem Başarılı.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $model = User::findOrFail($id);

        $image = $model->image;
        if (isset($image)) {
            Storage::delete("users/" . $model->image);
        }

        $model->image = null;
        $model->save();

        return redirect()->back()->with('message', 'İşlem Başarılı.');
    }

    public function uploadImage(Request $request)
    {
        $user = auth()->guard("user")->user();
        $user->fill($request->all())->save();
        return redirect()->back()->with('message', 'İşlem Başarılı.');
    }


}
