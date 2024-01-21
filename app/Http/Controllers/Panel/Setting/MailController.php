<?php

namespace App\Http\Controllers\Panel\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $model = new Setting();
        $mail = $model->get("email_settings");
        return view('panel.pages.setting.mail', compact('mail'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $model = new Setting();
        $builder = $request->all();

        foreach ($builder as $key => $value) {
            $model->set($key, [$value]);
        }

        return redirect()->back()->with('message', 'Kayıt İşlemi Başarılı');
    }
}
