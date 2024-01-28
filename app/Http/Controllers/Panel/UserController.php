<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->input('filter');

        $query = $filter
            ? User::where('name', 'LIKE', '%' . $filter . '%')
                ->orWhere('email', 'LIKE', '%' . $filter . '%')
                ->orWhere('role', 'LIKE', '%' . $filter . '%')
                ->orWhere('city', 'LIKE', '%' . $filter . '%')
                ->orWhere('status', 'LIKE', '%' . $filter . '%')
                ->orderBy("created_at", "DESC")
            : User::orderBy("created_at", "DESC");

        $users = $query->paginate(20);
        $users->appends(['filter' => $filter]);

        return view('panel.pages.users.user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panel.pages.users.userCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|unique:App\Models\User,email",
            "password" => "required",

        ]);
        $user = new User();
        $user->fill(array_merge([
            'password' => Hash::make($request->password)
        ], ["status" => $request->has("status") ? 1 : 0]))->fill($request->all())->save();
        return redirect()->route('panel.user.index')->with('message', 'Kayıt Başarılı');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('panel.pages.users.userEdit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $user->fill(array_merge($request->all(),
            ["status" => $request->has("status") ? 1 : 0]))->save();
        return redirect()->route('panel.user.index')->with('message', 'İşlem Başarılı');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
