<?php

namespace App\Http\Controllers\Panel\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $model = new Setting();
        $api = $model->get("api_settings");
        return view('panel.pages.setting.api', compact('api'));
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
