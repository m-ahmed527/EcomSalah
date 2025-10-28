<?php

namespace App\Repositories;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\Role;
use App\Models\User;
use App\Notifications\NewRegistrationNotification;
use App\Notifications\SchoolRegisterNotification;
use App\Services\OtpService;
use App\Traits\HasAuth;
use Exception;

class AuthRepository implements AuthRepositoryInterface
{
    use HasAuth;

    public function registerByEmailPassword(array $data, $remember = false)
    {
        try {
            $user = User::create($data);

            if ($user) {

                $credentials = [
                    'email' => $data['email'],
                    'password' => $data['password']
                ];
                $this->authenticate($credentials, $remember);
                $user->update([
                    'status' => User::ACTIVE,
                    'role' => User::USER,
                ]);
            }
            return successResponse('User registered successfully', $user);
        } catch (Exception $e) {
            return errorResponse($e->getMessage());
        }
    }

    public function registerByUserNamePassword(array $data, $remember)
    {
        $user = User::create($data);
        if ($user) {
            $credentials = [
                'user_name' => $data['user_name'],
                'password' => $data['password']
            ];
            $this->authenticate($credentials, $remember);
        }
    }

    public function registerByPhonePassword(array $data, $remember)
    {
        $user = User::create($data);
        if ($user) {
            $credentials = [
                'phone' => $data['phone'],
                'password' => $data['password']
            ];
            $this->authenticate($credentials, $remember);
        }
    }

    public function registerByOtp(array $data, $remember, $via = ['phone'], $expiry, $length = 6)
    {
        try {


            $otp = OtpService::generateOtp($length);
            $otp_expires_at = OtpService::generateOtpExpiry($expiry);
            $data['otp'] = $otp;
            $data['otp_expires_at'] = $otp_expires_at;
            $user = User::where('phone', $data['phone'])->orWhere('email', $data['email'])->first();
            if ($user) {
                $user->update(['otp' => $otp, 'otp_expires_at' => $otp_expires_at]);
            } else {
                $user = User::create($data);
            }

            (new OtpService())->sendOtp($otp, $data['phone'], $data['email'], $via, $expiry);
            // (new OtpService())->sendOtp($otp, $data['phone'], $data['email'], $via, $expiry);
            return response([
                'success' => true,
                'message' => 'Otp sent successfully',
                'user' => $user,
            ]);
        } catch (Exception $e) {
            return response([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
