<?php

namespace App\Http\Controllers\Panel\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $model = new Setting();
        $contact = $model->get("contact_settings");
        return view('panel.pages.setting.contact', compact('contact'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "address" => "required|sometimes",
            "email" => "required|sometimes|email",
            "phone" => "required|sometimes"
        ]);

        $model = new Setting();
        $builder = $request->all();

        foreach ($builder as $key => $value) {
            $model->set($key, [$value]);
        }

        return redirect()->back()->with('success', 'Kayıt İşlemi Başarılı');
    }
}
