<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CaptchaController extends Controller
{
    public function validateCaptcha(Request $request)
    {
        $rules = ['captcha' => 'required|captcha_api:'. $request->get('key') . ',math'];
        $validator = validator()->make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json(['error' => 'Captcha verification failed'], 400);
        } else {
            return response()->json(['message' => "Captcha verified"]);
        }
    }
}
