<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $pages = Page::published()->get();
        return view('admin.settings.index', ['pages' => $pages]);
    }

    public function save(Request $request)
    {
        $settings = $request->except('_token');

        Setting::setMany($settings);

        Toastr::success('The settings have been saved', 'Success');

        return redirect()->back();
    }
}
