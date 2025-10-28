<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\UpdateProfileRequest;
use Illuminate\Http\Request;
use Throwable;
class DashboardController extends Controller
{

    public function profile()
    {
        $user = auth()->user();
        if (request()->ajax()) {
            $html = view('includes.web.dashboard-components.profile', get_defined_vars())->render();
            return response()->json([
                "success" => true,
                'html' => $html,
            ], 200);
        }
        return view('screens.web.dashboard.index', get_defined_vars());
    }

    public function order()
    {
        if (request()->ajax()) {
            $html = view('includes.web.dashboard-components.order')->render();
            return response()->json([
                "success" => true,
                'html' => $html,
            ], 200);
        }
        return view('screens.web.dashboard.index');
    }

    public function profileUpdate(UpdateProfileRequest $request)
    {
        try {
            auth()->user()->update($request->sanitized());
            return successResponse("Profile updated successfully",['user' => auth()->user()->fresh()]);
        } catch (Throwable $e) {
            return errorResponse("Failed to update profile");
        }
    }

    public function updateProfileImage(Request $request)
    {
        try {
            $user = auth()->user();
            if ($request->hasFile('profile_image')) {
                $imageName = time() . '_' . uniqid() . '_' . $request->profile_image->getClientOriginalName();
                $request->profile_image->move(public_path('uploads/users/profile_images'), $imageName);
                $imageUrl = asset('uploads/users/profile_images/' . $imageName);
                $this->unlinkImage($user->avatar);
                $user->update([
                    'avatar' => $imageUrl,
                ]);
                return successResponse("Image updated successfully", [
                    'image_url' => $imageUrl,
                ]);
            }
            return errorResponse("No image found in the request");
        } catch (Throwable $e) {
            return errorResponse("Failed to update image");
        }
    }

    private function unlinkImage($imagePath)
    {
        if ($imagePath) {
            $filePath = public_path(parse_url($imagePath, PHP_URL_PATH));
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }
    }

}
