<?php

namespace App\Repositories;

use App\Interfaces\LoginRepositoryInterface;
use App\Models\User;
use App\Traits\HasAuth;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class LoginRepository implements LoginRepositoryInterface
{
    use HasAuth;

    function attemptLogin($credentials, $remember = false)
    {
        try {
            $authenticated = $this->authenticate($credentials, $remember);

            return response()->json([
                'success' => $authenticated,
                'message' => $authenticated ? 'Logged in successfully' : 'Invalid credentials',
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    function forgotPassword($email)
    {
        try {
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response([
                    'success' => false,
                    'message' => 'User not found',
                ]);
            } else {

                $token = $this->generateToken($email);
                $this->sendResetEmail($token, $email);

                return response([
                    'success' => true,
                    'message' => 'We have e-mailed your password reset link!',
                ]);
            }
        } catch (Exception $e) {
            return response([

                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    function resetPassword($request)
    {
        try {
            $updatePassword = $this->resetToken($request['email'], $request['token']);

            if (!$updatePassword) {
                return response([
                    'success' => false,
                    'message' => 'Token not found or expired',
                ]);
            }
            $user = $this->updatePassword($request['email'], $request['password']);
            DB::table('password_reset_tokens')->where(['email' => $request['email']])->delete();
            if ($user) {
                return response([
                    'success' => true,
                    'message' => 'Password updated successfully',
                ]);
            }
        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function generateToken($email)
    {
        $token = Str::random(64);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email], // Condition to check
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        return $token;
    }
    private function sendResetEmail($token, $email)
    {
        Mail::send('emails.forgotPassword', [
            'token' => $token,
            'email' => $email
        ], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Reset Password');
        });
    }

    private function resetToken($email, $token)
    {
        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $email,
                'token' => $token
            ])->first();
        return $updatePassword;
    }

    private function updatePassword($email, $password)
    {
        return User::where('email', $email)
            ->update(['password' => Hash::make($password)]);
    }
}
