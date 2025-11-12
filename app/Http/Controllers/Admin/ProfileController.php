<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Profile\UpdateProfileRequest;
use Illuminate\Http\Request;
use Throwable;

class ProfileController extends Controller
{
    public function index()
    {
         $breadcrumbs = [
            'Dashboard' => route('admin.index'),
            'Update Profile' => route('admin.profile.index'),
        ];
        return view('screens.admin.profile.index',get_defined_vars());
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            auth()->user()->update($request->sanitized());
            return successResponse("Profile updated successfully");
        } catch (Throwable $e) {
            create_error_log('Profile Update', $e);
            return errorResponse("Something went wrong.");
        }
    }
}
