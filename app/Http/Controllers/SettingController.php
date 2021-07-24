<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function save(Request $request)
    {
        $settings = $request->except('_token');

        Setting::setMany($settings);

        Toastr::success('The settings have been saved', 'Success');

        return redirect()->back();
    }
}
