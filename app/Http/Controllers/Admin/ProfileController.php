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
        return view('screens.admin.profile.index');
    }

    public function update(UpdateProfileRequest $request)
    {
        try {
            auth()->user()->update($request->sanitized());
            return successResponse("Profile updated successfully");
        } catch (Throwable $e) {
            return errorResponse("Something went wrong.");
        }
    }
}
