<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function registerByEmailPassword(array $credentials, $remember);
    public function registerByUserNamePassword(array $credentials, $remember);
    public function registerByPhonePassword(array $credentials, $remember);
    public function registerByOtp(array $credentials, $remember, array $via, int $expiry);
}
