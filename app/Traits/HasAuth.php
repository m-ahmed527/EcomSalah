<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait HasAuth
{
    public function authenticate(array $credentials, $remember = false)
    {
        if (empty($credentials)) {
            $user = $this->validatedRequest(request()->all());

            if ($user) {
                Auth::login($user, $remember);
                return true;
            }
        } else {
            if (Auth::attempt($credentials, $remember)) {
                return true;
            }
        }
        return false;
    }


    public function validatedRequest($request)
    {
        if (isset($request['email'])) {
            return User::where('email', $request['email'])->first();
            // return User::whereAny(['user_name', 'email', 'phone'], $request['input_field'])->first();
        }
        return null;
    }
}
