<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Setting\UpdateSettingRequest;
use App\Models\Setting;
use Illuminate\Http\Request;
use Throwable;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('screens.admin.settings.index', get_defined_vars());
    }

    // public function update(Request $request)
    // {
    //     try {
    //         dd($request->all());
    //         $data = $request->except('_token');

    //         // Handle logo upload
    //         if ($request->hasFile('logo')) {
    //             $logoName = $request->logo->getClientOriginalName();
    //             $request->logo->move(public_path('uploads/settings/'), $logoName);
    //             $data['logo'] = asset('uploads/settings/' . $logoName);
    //         }

    //         // Handle favicon upload
    //         if ($request->hasFile('favicon')) {
    //             $faviconName = $request->favicon->getClientOriginalName();
    //             $request->favicon->move(public_path('uploads/settings/'), $faviconName);
    //             $data['favicon'] = asset('uploads/settings/' . $faviconName);
    //         }

    //         foreach ($data as $key => $value) {
    //             Setting::set($key, $value);
    //         }

    //         return successResponse("Settings updated successfully");
    //     } catch (Throwable $e) {
    //         create_error_log('Setting Update', $e);
    //         return errorResponse("Something went wrong");
    //     }
    // }


    public function update(UpdateSettingRequest $request)
    {
        try {
            $data = $request->sanitized();
            Setting::updateSettings($data);
            return successResponse("Settings updated successfully.");
        } catch (Throwable $e) {
            create_error_log('Setting Update', $e);
            return errorResponse("Something went wrong.");
        }
    }
}
