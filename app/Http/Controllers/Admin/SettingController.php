<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Page;
use App\Models\Setting;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $pages = Page::published()->get();
        $featuredProductImage = Image::find(setting('featured_product_image'));
        $brands = [];

        if(setting('brands_images')) {
            $brands = Image::whereIn('id', setting('brands_images'))->get();
        }

        return view('admin.settings.index', ['pages' => $pages, 'image' => $featuredProductImage, 'brands' => $brands]);
    }

    public function save(Request $request)
    {
        $settings = $request->except('_token');

        Setting::setMany($settings);

        Toastr::success('The settings have been saved', 'Success');

        return redirect()->back();
    }
}
